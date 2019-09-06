package com.defecttracking.defect.controller;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.mvc.Controller;
import org.springframework.web.servlet.mvc.SimpleFormController;
import org.springframework.web.servlet.view.RedirectView;

import com.defecttracking.connection.DWRConnection;
import com.defecttracking.defect.bean.Defect;
import com.defecttracking.defect.bean.Presentation;
import com.defecttracking.defect.bean.Query;
import com.defecttracking.defect.bean.QueryFilter;
import com.defecttracking.defect.command.Column;
import com.defecttracking.defect.command.DefectCommand;
import com.defecttracking.defect.command.QueryCommand;
import com.defecttracking.defect.service.DefectManager;
import com.defecttracking.user.service.UserManager;


public class CreateNewQueryController extends SimpleFormController{


/*	public ModelAndView handleRequest(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException,Exception {
		
		String sql="select* from tbldefect";
		List columnsList=DWRConnection.getColumnNames(sql);
		for(int i=0;i<columnsList.size();i++)
		{
			Column column=(Column)columnsList.get(i);
			System.out.println(column.getColumnName());
		}
		ModelAndView modelAndView = new ModelAndView("createQuery");
		HttpSession session = request.getSession(true);
		
		return modelAndView;

	}*/
	
	private DefectManager defectManager;

	HttpSession session=null;
	//String queryType=null;
	String userId=null;
	String queryType=null;
		public void setDefectManager(DefectManager defectManager) {
		this.defectManager = defectManager;
	}
		
	
		protected Object formBackingObject(HttpServletRequest request)
				throws Exception {
			QueryCommand queryCommand = new QueryCommand();
			ModelAndView modelAndView=new ModelAndView("createQuery");
			HttpSession session = request.getSession();
			userId=(String)session.getAttribute("uid");
			queryType=request.getParameter("qType");
			
			//System.out.println("UserId "+userId);
			//System.out.println("QueryType "+queryType);			
			
			return queryCommand;
		}
		
		
		protected Map referenceData(HttpServletRequest request) throws Exception {
			Map dataMap = new HashMap();
			String sql="select* from tbldefect";
			List columnsList=DWRConnection.getColumnNames(sql);
		/*	for(int i=0;i<columnsList.size();i++)
			{
				Column column=(Column)columnsList.get(i);
				System.out.println(column.getColumnName());
			}*/
			
			dataMap.put("columnsList", columnsList);
			return dataMap;
		}
		
		
		
		
		public ModelAndView onSubmit(Object command) throws ServletException {
			QueryCommand queryCommand = (QueryCommand) command;
			Query query=new Query();
			query.setQueryName(queryCommand.getQueryName());
			query.setUserId(userId);
			query.setQueryType(queryType);
			//System.out.println("Filter Fields "+queryCommand.getFilterName());
			/*QueryFilter queryFilter=new QueryFilter();
			queryFilter.setQuery(query);
			queryFilter.setFilterName("PRIORITY");
			queryFilter.setDefaultValue("P1");*/
			
			
			
			if (null != queryCommand.getFilterName()) {
				String[] selectedFields = queryCommand.getFilterName()
						.split("&");
				if (null != selectedFields) {
					for (int i = 0; i < selectedFields.length; i++) {
						QueryFilter queryFilter=new QueryFilter();
						queryFilter.setQuery(query);
						queryFilter.setFilterName(selectedFields[i]);
						queryFilter.setDefaultValue("P1");
						//defectManager.saveQueryFilter(queryFilter);
					}
				}
			}
			
			//System.out.println("Presentation fields "+queryCommand.getPresentationFeldsName());
			if (null != queryCommand.getPresentationFeldsName()) {
				String[] presentationFields = queryCommand.getPresentationFeldsName()
						.split("&");
				if (null != presentationFields) {
					for (int i = 0; i < presentationFields.length; i++) {
						Presentation presentation=new Presentation();
						presentation.setQuery(query);
						presentation.setPresentationField(presentationFields[i]);						
					//	defectManager.savePresentationFields(presentation);
					}
				}
			}
			//defectManager.saveQuery(query);
			//defectManager.saveQueryFilter(queryFilter);
			return new ModelAndView(new RedirectView(getSuccessView()));

		}
		
		}
		
		
	
	
	

