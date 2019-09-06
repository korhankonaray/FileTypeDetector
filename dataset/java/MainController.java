package com.defecttracking.defect.controller;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.SimpleFormController;
import org.springframework.web.servlet.view.RedirectView;

import com.defecttracking.defect.bean.Defect;
import com.defecttracking.defect.bean.Priority;
import com.defecttracking.defect.bean.Severity;
import com.defecttracking.defect.bean.State;
import com.defecttracking.defect.command.DefectCommand;
import com.defecttracking.defect.service.DefectManager;
import com.defecttracking.project.bean.Project;
import com.defecttracking.project.service.ProjectManager;
import com.defecttracking.user.bean.User;
import com.defecttracking.user.command.UserCommand;
import com.defecttracking.user.service.UserManager;

public class MainController extends SimpleFormController{

	
private DefectManager defectManager;
private UserManager userManager;
private ProjectManager projectManager;


	public void setDefectManager(DefectManager defectManager) {
	this.defectManager = defectManager;
}
	
	String defectId=null;
	String userId=null;
	protected Object formBackingObject(HttpServletRequest request)
			throws Exception {
		DefectCommand defectCommand = new DefectCommand();
		HttpSession session = request.getSession(true);
		userId=(String)session.getAttribute("uid");
		ModelAndView modelAndView = new ModelAndView();
		if(userId!=null)
		{
		Defect defect=new Defect();		
		defectId=request.getParameter("DId");
		if(defectId!=null)
		{
		session.setAttribute("defId", defectId);
		}
		else
		{
			defectId=(String)session.getAttribute("defId");
		}
		if(defectId!=null)
		{		
		List defectDetails=defectManager.getDefectListById(defectId);
		defect=(Defect)defectDetails.get(0);
		
		defectCommand.setAreaAffected(defect.getAreaAffected());
		defectCommand.setCrType(defect.getCrType());
		//defectCommand.setDefectHistory(defectHistory)
		defectCommand.setDefectId(defect.getDefectId());
		//defectCommand.setDefectNotes(defectNotes)
		defectCommand.setDescription(defect.getDescription());
		defectCommand.setEnvironment(defect.getEnvironment());
		defectCommand.setHeadLine(defect.getHeadLine());
		defectCommand.setPriority(defect.getPriority());
		defectCommand.setProject(defect.getProject());
		defectCommand.setQualitedInVersion(defect.getQualitedInVersion());
		defectCommand.setQualityCenterRef(defect.getQualityCenterRef());
		defectCommand.setRemedyRef(defect.getRemedyRef());
		defectCommand.setResolutionGroup(defect.getResolutionGroup());
		defectCommand.setSeverity(defect.getSeverity());
		defectCommand.setState(defect.getState());
		defectCommand.setSubmittedDate(defect.getSubmittedDate());
		defectCommand.setSubmitterId(defect.getSubmitterId());
		defectCommand.setSubmitterName(defect.getSubmitterName());
		defectCommand.setTestPhase(defect.getTestPhase());
		defectCommand.setUserId(defect.getUserId());
		
		
		List userList=userManager.getUserListById(defect.getUserId());
		if(userList.size()>0)
		{
			User user=(User)userList.get(0);
			defectCommand.setUsreName(user.getFullName());
		}
		}
		modelAndView.setViewName("main");
		}
		else
		{
			modelAndView.setViewName("index");
		}
		return defectCommand;
	}
	
	
	protected Map referenceData(HttpServletRequest request) throws Exception {
		Map dataMap = new HashMap();
		/*List severityList=new ArrayList();
		List stateList=new ArrayList();
		List priorityList=new ArrayList();
		
		Severity severity=new Severity();
		severity.setSeverityId(1);
		severity.setSeverityValue("ABC");
		severityList.add(severity);
		
		severity=new Severity();
		severity.setSeverityId(2);
		severity.setSeverityValue("XYZ");
		severityList.add(severity);	
		
		dataMap.put("severityList", severityList);
		
		
		State state=new State();
		state.setStateId(1);
		state.setStateValue("Integration Failed");
		stateList.add(state);
		
		state=new State();
		state.setStateId(2);
		state.setStateValue("Integration Tested");
		stateList.add(state);
		
		state=new State();
		state.setStateId(3);
		state.setStateValue("Unit Tested");
		stateList.add(state);
		
		state=new State();
		state.setStateId(4);
		state.setStateValue("Close");
		stateList.add(state);
		
		state=new State();
		state.setStateId(5);
		state.setStateValue("Fixed");
		stateList.add(state);
		
		state=new State();
		state.setStateId(6);
		state.setStateValue("Opened");
		stateList.add(state);
		
		state=new State();
		state.setStateId(7);
		state.setStateValue("Assigned");
		stateList.add(state);
		
		state=new State();
		state.setStateId(8);
		state.setStateValue("Submitted");
		stateList.add(state);
		
		dataMap.put("stateList", stateList);
		
		Priority priority=new Priority();
		priority.setPriorityId(1);
		priority.setPriorityValue("P1");
		priorityList.add(priority);
		
		priority=new Priority();
		priority.setPriorityId(1);
		priority.setPriorityValue("P2");
		priorityList.add(priority);
		
		priority=new Priority();
		priority.setPriorityId(1);
		priority.setPriorityValue("P3");
		priorityList.add(priority);
		
		priority=new Priority();
		priority.setPriorityId(1);
		priority.setPriorityValue("P4");
		priorityList.add(priority);
		
		dataMap.put("priorityList", priorityList);*/
		
		List userList=userManager.getUserList();			
		dataMap.put("userList", userList);
		
		List projectList=projectManager.getProjectList();
		if(projectList!=null && projectList.size()>0)
		{
			for(int i=0;i<projectList.size();i++)
			{
			Project project=(Project)projectList.get(i);
			project.setProjectCode(project.getProjectCode()+" - "+project.getProjectName());
			}
		}
		dataMap.put("projectList", projectList);	
		
		return dataMap;
	}
	

	public ModelAndView onSubmit(Object command) throws ServletException {
		DefectCommand defectCommand = (DefectCommand) command;
		String forward=null;
		if(userId!=null)
		{
		Defect defect=new Defect();
		defect.setDefectId(Long.parseLong(defectId));
		defect.setAreaAffected(defectCommand.getAreaAffected());
		defect.setCrType(defectCommand.getCrType());		
		defect.setDescription(defectCommand.getDescription());
		defect.setEnvironment(defectCommand.getEnvironment());
		defect.setHeadLine(defectCommand.getHeadLine());
		defect.setPriority(defectCommand.getPriority());
		defect.setProject(defectCommand.getProject());
		defect.setQualitedInVersion(defectCommand.getQualitedInVersion());
		defect.setQualityCenterRef(defectCommand.getQualityCenterRef());
		defect.setRemedyRef(defectCommand.getRemedyRef());
		defect.setResolutionGroup(defectCommand.getResolutionGroup());
		defect.setSeverity(defectCommand.getSeverity());
		defect.setState(defectCommand.getState());
		defect.setSubmittedDate(defectCommand.getSubmittedDate());
		defect.setSubmitterId(defectCommand.getSubmitterId());
		defect.setSubmitterName(defectCommand.getSubmitterName());
		defect.setTestPhase(defectCommand.getTestPhase());
		defect.setUserId(defectCommand.getUserId());
		defect.setModifiedby(userId);
		defect.setModificationdate(getDateTime());
		forward="main.html?DId="+defect.getDefectId();		
		defectManager.saveDefect(defect);
		}
		else
		{
			forward="login.html";
		}
		
		
		
		
		return new ModelAndView(new RedirectView(forward));

	}

	public void setUserManager(UserManager userManager) {
		this.userManager = userManager;
	}


	public void setProjectManager(ProjectManager projectManager) {
		this.projectManager = projectManager;
	}


	/**
	 * This function is use for get the current date 
	 * @return String date
	 */
	
	private String getDateTime() {
		DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		Date date = new Date();
		return dateFormat.format(date);
	}
	
}
