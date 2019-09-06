package com.defecttracking.defect.controller;

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

import com.defecttracking.defect.bean.Notes;
import com.defecttracking.defect.command.NotesCommand;
import com.defecttracking.defect.service.DefectManager;

public class NotesController extends SimpleFormController{
	
	
	
	
	private DefectManager defectManager;

		public void setDefectManager(DefectManager defectManager) {
		this.defectManager = defectManager;
	}
		
	
		String defectId=null;
		String notesComment="";
		String userId=null;
		protected Object formBackingObject(HttpServletRequest request)
				throws Exception {
			NotesCommand notesCommand= new NotesCommand();	
			HttpSession session=request.getSession();
			userId=(String)session.getAttribute("uid");
			ModelAndView modelAndView = new ModelAndView();
			notesComment="";
			if(userId!=null)
			{
			defectId=(String)session.getAttribute("defId");
			if(defectId!=null)
			{
				List notesList=defectManager.getNotesListByDefectId(defectId);
				//System.out.println("Size: "+ notesList.size());
				if(notesList!=null && notesList.size()>0)
				{
					for(int i=0;i<notesList.size();i++)
					{
					Notes notes=(Notes)notesList.get(i);
					String userid=notes.getUserId();
					String submitDate=notes.getSubmittedDate();
					String comment=notes.getComments();
					notesComment=notesComment+"<br/> <label class='label_text1'>"+userid+"("+submitDate+"): </label>"+comment+"<br/>";
					}
					notesCommand.setAllComments(notesComment);
				}
			}
			modelAndView.setViewName("notes");
			}
			else
			{
				modelAndView.setViewName("index");
			}
			return notesCommand;
		}
		

		public ModelAndView onSubmit(Object command) throws ServletException {
			NotesCommand notesCommand = (NotesCommand) command;
			String forword=null;
			if(userId!=null)
			{
			Notes notes=new Notes();
			notes.setDefectId(Long.parseLong(defectId));
			notes.setUserId(userId);
			notes.setSubmittedDate(getDateTime());
			notes.setComments(notesCommand.getComments());
			defectManager.saveNotes(notes);
			notesComment="";
			forword=getSuccessView();
			}
			else
			{			
				forword="login.html";
			}
			
			//defectManager.saveQuery(query);
			
			return new ModelAndView(new RedirectView(forword));

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
	
	
	
	
	/*public ModelAndView handleRequest(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		ModelAndView modelAndView = new ModelAndView("notes");
		HttpSession session = request.getSession(true);
		
		return modelAndView;

	}*/

}
