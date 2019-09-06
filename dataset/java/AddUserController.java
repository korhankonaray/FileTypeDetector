package com.defecttracking.user.controller;


import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

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
 * Class Name: AddUserController
 * ********************************************************************************
 * Class Description : This class is used to open add user page
 * ******************************************************************************** *
 * Creation Date : 20/8/2010
 * ******************************************************************************** *
 * 
 * @author Sudipta Bera
* *********************************************************************************
 * Name 		Date			 Defect/CR 					Description
 * ********************************************************************************
 * 
 * 
 */

public class AddUserController extends SimpleFormController{
	
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
	String userid=null;
	protected Object formBackingObject(HttpServletRequest request)
	throws Exception {
		UserCommand userCommand = new UserCommand();
		ModelAndView modelAndView = new ModelAndView();
		modelAndView.setViewName("addUser");
		session = request.getSession();	
		 userid=(String)session.getAttribute("uid");
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
		if(userid!=null)
		{
		user.setUserId(userCommand.getUserId());
		user.setPassword(userCommand.getPassword());
		user.setFullName(userCommand.getFullName());	
		user.setEmail(userCommand.getEmail());
		user.setPhone(userCommand.getPhone());
		user.setRoleid(2);
		user.setCreatedby(userid);
		user.setCreationdate(getDateTime());
		userManager.saveUser(user);		
		redirectPath="viewUser.html";
		}
		else
		{
			redirectPath="login.html";
		}
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
