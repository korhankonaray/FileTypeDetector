package com.defecttracking.defect.controller;

import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Properties;

import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.AddressException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.SimpleFormController;
import org.springframework.web.servlet.view.RedirectView;

import com.defecttracking.defect.bean.Defect;
import com.defecttracking.defect.bean.Notes;
import com.defecttracking.defect.command.DefectCommand;
import com.defecttracking.defect.service.DefectManager;
import com.defecttracking.project.bean.Project;
import com.defecttracking.project.service.ProjectManager;
import com.defecttracking.user.bean.User;
import com.defecttracking.user.service.UserManager;

public class AddNewDefectController extends SimpleFormController {

	
	private DefectManager defectManager;
	private UserManager userManager;
	private ProjectManager projectManager;
	HttpSession session=null;
	String userId=null;

		
		String defectId=null;
		protected Object formBackingObject(HttpServletRequest request)
				throws Exception {
			DefectCommand defectCommand = new DefectCommand();
			ModelAndView modelAndView = new ModelAndView();
			session = request.getSession(true);
			userId=(String)session.getAttribute("uid");
			if(userId!=null)
			{
			Defect defect=new Defect();
			defectId=defectManager.getLastDefectId();	
			if(defectId!=null){				
				defectCommand.setDefectId(Long.parseLong(defectId)+1);	
			}
			else
			{
				defectId="0";
				defectCommand.setDefectId(Long.parseLong(defectId)+1);
			}
			defectCommand.setState("Submitted");
			modelAndView.setViewName("addNewDefect");
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
	
		// create a method to check user id and password for login in home page and
		// set session value

		public ModelAndView onSubmit(Object command) throws ServletException,UnsupportedEncodingException {
			DefectCommand defectCommand = (DefectCommand) command;
			if(userId!=null)
			{
			Defect defect=new Defect();			
			defect.setAreaAffected(defectCommand.getAreaAffected());
			defect.setCrType(defectCommand.getCrType());
			defect.setDefectId(defectCommand.getDefectId());
			defect.setDescription(defectCommand.getNotes());
			defect.setEnvironment(defectCommand.getEnvironment());
			defect.setHeadLine(defectCommand.getHeadLine());
			defect.setPriority(defectCommand.getPriority());
			defect.setProject(defectCommand.getProject());
			defect.setQualitedInVersion(defectCommand.getQualitedInVersion());
			defect.setQualityCenterRef(defectCommand.getQualityCenterRef());
			defect.setRemedyRef(defectCommand.getQualityCenterRef());
			defect.setResolutionGroup(defectCommand.getResolutionGroup());
			defect.setSeverity(defectCommand.getSeverity());
			defect.setState(defectCommand.getState());			
			defect.setTestPhase(defectCommand.getTestPhase());
			defect.setUserId(defectCommand.getUserId());			
			defect.setSubmitterId(userId);
			List userList=userManager.getUserListById(userId);
			List ownerList=userManager.getUserListById(defect.getUserId());
			if(ownerList.size()>0)
			{
				User user=(User)ownerList.get(0);
				defect.setUsreName(user.getFullName());
			}
			if(userList.size()>0)
			{
				User user=(User)userList.get(0);
				defect.setSubmitterName(user.getFullName());
			}
						
			
			defect.setSubmittedDate(getDateTime());			
			defectManager.saveDefect(defect);
			//System.out.println("Save Successfull");
			
			Notes notes=new Notes();
			notes.setDefectId(defectCommand.getDefectId());
			notes.setUserId(userId);
			notes.setSubmittedDate(getDateTime());
			notes.setComments(defectCommand.getNotes());
			defectManager.saveNotes(notes);
			
			// Mail Sending
			
			
			Properties props = new Properties();
	        Session session = Session.getDefaultInstance(props, null);

	        String msgBody = "New Defect";

	        try {
	            Message msg = new MimeMessage(session);
	            msg.setFrom(new InternetAddress("sudiptabera85@gmail.com", "euphern.com Admin"));
	            msg.addRecipient(Message.RecipientType.TO,
	                             new InternetAddress("sudiptabera85@gmail.com", "Mr. User"));
	            msg.setSubject("Your Example.com account has been activated");
	            msg.setText(msgBody);
	            Transport.send(msg);

	        } catch (AddressException e) {

	        	System.out.println("Exception: "+e);
	        } catch (MessagingException e) {
	        	System.out.println("Exception: "+e);
	        }
			
			
			
			}
			return new ModelAndView(new RedirectView(getSuccessView()));

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
		

		public void setDefectManager(DefectManager defectManager) {
		this.defectManager = defectManager;
	}
		
		public void setUserManager(UserManager userManager) {
			this.userManager = userManager;
		}

		public void setProjectManager(ProjectManager projectManager) {
			this.projectManager = projectManager;
		}
		
		
		

}
