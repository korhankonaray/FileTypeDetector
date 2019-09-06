package com.defecttracking.project.controller;


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

import com.defecttracking.project.bean.Project;
import com.defecttracking.project.command.ProjectCommand;
import com.defecttracking.project.service.ProjectManager;


/**
 * Class Name: AddProjectController
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

public class AddProjectController extends SimpleFormController{
	
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
	protected Object formBackingObject(HttpServletRequest request)
	throws Exception {
		ProjectCommand projectCommand = new ProjectCommand();
		ModelAndView modelAndView = new ModelAndView();
		modelAndView.setViewName("addProject");
		session = request.getSession();	
		 userid=(String)session.getAttribute("uid");		
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
			project.setProjectCode(projectCommand.getProjectCode());
			project.setProjectName(projectCommand.getProjectName());
			project.setClientName(projectCommand.getClientName());
			project.setTechnology(projectCommand.getTechnology());
			project.setStartDate(projectCommand.getStartDate());
			project.setTotalDay(projectCommand.getTotalDay());
			project.setDescription(projectCommand.getDescription());
			project.setCreatedby(userid);
			project.setCreationdate(getDateTime());
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
