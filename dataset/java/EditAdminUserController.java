package com.defecttracking.user.controller;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.SimpleFormController;
import org.springframework.web.servlet.view.RedirectView;

import com.defecttracking.user.bean.User;
import com.defecttracking.user.command.UserCommand;
import com.defecttracking.user.service.UserManager;

/**
 * Class Name: EditAdminUserController
 * ********************************************************************************
 * Class Description : This class is used to open edit user 
 * page with the details of selected user
 * ******************************************************************************** *
 * Creation Date : 22/8/2010
 * ******************************************************************************** *
 * 
 * @author Sudipta Bera
* *********************************************************************************
 * Name 		Date			 Defect/CR 					Description
 * ********************************************************************************
 * 
 * 
 */

public class EditAdminUserController extends SimpleFormController{
	
	private UserManager userManager;
	HttpSession session;
	
	/**
	 * Create a method to open the add user page
	 * ******************************
	 * 
	 * @param HttpServletRequest	 
	 * @throws IOException
	 * @return object of the command class
	 */
	
	String password=null;
	String createdby=null;
	String creationdate=null;
	String loginuserid=null;
	String userid=null;
	int roleid;
	protected Object formBackingObject(HttpServletRequest request)
	throws Exception {
		UserCommand userCommand = new UserCommand();
		ModelAndView modelAndView = new ModelAndView();
		
		session = request.getSession();		
		loginuserid=(String)session.getAttribute("uid");
		userid=request.getParameter("userId");
		
		if(loginuserid!=null)
		{
			List userList=userManager.getUserListById(userid);
			if(userList!=null)
			{
			User user=(User)userList.get(0);
			userCommand.setUserId(user.getUserId());		
			userCommand.setFullName(user.getFullName());
			userCommand.setEmail(user.getEmail());
			userCommand.setPhone(user.getPhone());
			roleid=user.getRoleid();
			password=user.getPassword();
			createdby=user.getCreatedby();
			creationdate=user.getCreationdate();
			}
			modelAndView.setViewName("editUser");
		}
		else
		{
			modelAndView.setViewName("index");
		}
		return userCommand;
	}
	
	
	/**
	 * Create a method to save a new user details
	 * ******************************
	 * 
	 * @param object of the command class	
	 * @throws ServletException
	 * @return ModelAndView
	 */
	public ModelAndView onSubmit(Object command) throws ServletException {
		UserCommand userCommand = (UserCommand) command;
		User user = new User();
		String redirectPath = null;		
		user.setUserId(userid);
		user.setPassword(password);
		user.setFullName(userCommand.getFullName());	
		user.setEmail(userCommand.getEmail());
		user.setPhone(userCommand.getPhone());
		user.setRoleid(roleid);
		user.setCreatedby(createdby);
		user.setCreationdate(creationdate);
		user.setModifiedby(loginuserid);
		user.setModificationdate(getDateTime());
		userManager.saveUser(user);		
		redirectPath="viewAdmin.html";
		return new ModelAndView(new RedirectView(redirectPath));
	}


	/**
	 * Create a method setter method of UserManager class
	 * ****************************** * 
	 * @param object of the UserManager class	
	 * @return no return
	 */

	public void setUserManager(UserManager userManager) {
		this.userManager = userManager;
	}

	
	/**
	 * This function is use for get the current date 
	 * @return String date
	 */
	
	private String getDateTime() {
		DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
		Date date = new Date();
		return dateFormat.format(date);
	}
	

}
