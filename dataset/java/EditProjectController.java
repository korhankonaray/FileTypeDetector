package com.defecttracking.project.controller;

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

import com.defecttracking.project.bean.Project;
import com.defecttracking.project.command.ProjectCommand;
import com.defecttracking.project.service.ProjectManager;
import com.defecttracking.user.bean.User;
import com.defecttracking.user.command.UserCommand;
import com.defecttracking.user.service.UserManager;

/**
 * Class Name: EditUserController
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

public class EditProjectController extends SimpleFormController{
	private ProjectManager projectManager;
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
	String projectid=null;
	String creationdate=null;
	String createdby=null;
	protected Object formBackingObject(HttpServletRequest request)
	throws Exception {
		ProjectCommand projectCommand = new ProjectCommand();
		ModelAndView modelAndView = new ModelAndView();
		modelAndView.setViewName("editProject");
		session = request.getSession();	
		 userid=(String)session.getAttribute("uid");
		 if(userid!=null)
		 {
			 projectid=request.getParameter("prjid");
			 List projectList=projectManager.getProjectListById(projectid);
			 if(projectList!=null && projectList.size()>0)
			 {
				 Project project=(Project)projectList.get(0);
				 projectCommand.setProjectCode(project.getProjectCode());
				 projectCommand.setProjectName(project.getProjectName());
				 projectCommand.setClientName(project.getClientName());
				 projectCommand.setTechnology(project.getTechnology());
				 projectCommand.setTotalDay(project.getTotalDay());
				 projectCommand.setStartDate(project.getStartDate());
				 projectCommand.setDescription(project.getDescription());
				 createdby=project.getCreatedby();
				 creationdate=project.getCreationdate();
			 }
		 }
		return projectCommand;
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
		ProjectCommand projectCommand = (ProjectCommand) command;
		Project project = new Project();
		String redirectPath = null;		
		if(userid!=null)
		{
			project.setProjectId(Long.parseLong(projectid));
			project.setProjectCode(projectCommand.getProjectCode());
			project.setProjectName(projectCommand.getProjectName());
			project.setClientName(projectCommand.getClientName());
			project.setTechnology(projectCommand.getTechnology());
			project.setStartDate(projectCommand.getStartDate());
			project.setTotalDay(projectCommand.getTotalDay());
			project.setDescription(projectCommand.getDescription());
			project.setCreatedby(createdby);
			project.setCreationdate(creationdate);
			project.setModifiedby(userid);
			project.setModificationdate(getDateTime());
			projectManager.saveProject(project);
			redirectPath="viewProject.html";
		}
		else
		{
			redirectPath="login.html";
		}
		return new ModelAndView(new RedirectView(redirectPath));
	}

	
	/**
	 * Create a method setter method of ProjectManager class
	 * ****************************** * 
	 * @param object of the ProjectManager class	
	 * @return no return
	 */


	public void setProjectManager(ProjectManager projectManager) {
		this.projectManager = projectManager;
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
