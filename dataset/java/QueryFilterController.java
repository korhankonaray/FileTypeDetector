package com.defecttracking.defect.controller;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.GregorianCalendar;
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
import com.defecttracking.defect.bean.Presentation;
import com.defecttracking.defect.bean.QueryFilter;
import com.defecttracking.defect.command.DefectCommand;
import com.defecttracking.defect.command.QueryFilterCommand;
import com.defecttracking.defect.service.DefectManager;
import com.defecttracking.user.command.UserCommand;

public class QueryFilterController extends SimpleFormController{

private DefectManager defectManager;
private List filterList=new ArrayList();	
HttpSession session=null;
String userId=null;	
String queryId=null;
	public void setDefectManager(DefectManager defectManager) {
		this.defectManager = defectManager;
	}

	protected Object formBackingObject(HttpServletRequest request)
	throws Exception {
		QueryFilterCommand queryFilterCommand=new QueryFilterCommand();
		session = request.getSession(true);
		userId=(String)session.getAttribute("uid");
		queryId=request.getParameter("queryId");
		
		return queryFilterCommand;
}

	
	protected Map referenceData(HttpServletRequest request) throws Exception {
		Map dataMap = new HashMap();
		
		//filterList=defectManager.getFilterListByQueryId(queryId);
		dataMap.put("filterList", filterList);
		
		System.out.println("Size "+filterList.size());
		for(int i=0; i<filterList.size();i++)
		{
			QueryFilter queryFilterCommand=(QueryFilter)filterList.get(i);
			System.out.println("Filter Name "+queryFilterCommand.getFilterName());
			System.out.println("Filter Value "+queryFilterCommand.getDefaultValue());			
		}
		return dataMap;
	}
	
	
	
	public ModelAndView onSubmit(Object command) throws ServletException {
		QueryFilterCommand queryFilterCommand=(QueryFilterCommand)command;
		System.out.println(queryFilterCommand.getPath1());
		System.out.println(queryFilterCommand.getPath2());
		System.out.println(queryFilterCommand.getPath3());
		String [] defaultValue={queryFilterCommand.getPath1(),queryFilterCommand.getPath2(),queryFilterCommand.getPath3()};
		String filtersName="";
		for(int i=0;i<filterList.size();i++)
		{
			QueryFilter queryFilter=(QueryFilter)filterList.get(i);
			filtersName=filtersName+queryFilter.getFilterName()+"="+"'"+ defaultValue[i]+"'";
			if(i<filterList.size()-1)
			{
				filtersName=filtersName+" and ";
			}
		}		
		System.out.println(filtersName);
		
		List presentationFieldsList=new ArrayList();
			//presentationFieldsList=defectManager.getPresentationFieldsListByQueryId(queryId);
		System.out.println("Size: "+presentationFieldsList.size());
		
		for(int i=0;i<presentationFieldsList.size();i++)
		{
			Presentation presentation=(Presentation)presentationFieldsList.get(i);
			System.out.println("Field Name"+presentation.getPresentationField());
		}
		List defectList=new ArrayList();
		//defectList=defectManager.getDefectListByFilterName(userId,presentationFieldsList, filterList, defaultValue);
		System.out.println(defectList);
		session.setAttribute("defectList", defectList);
		session.setAttribute("presentationFieldsList", presentationFieldsList);
		System.out.println("Query Size "+defectList.size());
	//	System.out.println("VAl1 "+(String)defectList.get(0));
		
	/*	String str[]=(String []) defectList.toArray (new String [defectList.size ()]);
		for(int i=0;i<defectList.size();i++)
		{
			System.out.println("Val "+str[i]);
		}*/
		for(int i=0;i<defectList.size();i++)
		{
			Defect defect=(Defect)defectList.get(i);
			System.out.println(defect.getDefectId());
			System.out.println(defect.getPriority());
			System.out.println(defect.getProject());
			System.out.println(defect.getHeadLine());
			
		}
		return new ModelAndView(new RedirectView(getSuccessView()));
				
	}
	
/*
	public ModelAndView handleRequest(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		ModelAndView modelAndView = new ModelAndView("home");
		HttpSession session = request.getSession();
		String filterName=null;
		String filterValue=null;
		String userId=(String)session.getAttribute("uid");
		String queryId=request.getParameter("queryId");
		System.out.println("QueryId "+queryId);
		if(queryId!=null)
		{
		List filterList=defectManager.getFilterListByQueryId(queryId);
		modelAndView.addObject("filterList", filterList);
		System.out.println("Size "+filterList.size());
		for(int i=0; i<filterList.size();i++)
		{
			QueryFilter queryFilter=(QueryFilter)filterList.get(i);
			System.out.println("Filter Name "+queryFilter.getFilterName());
			System.out.println("Filter Value "+queryFilter.getDefaultValue());
			filterName=queryFilter.getFilterName();
			filterValue=queryFilter.getDefaultValue();
			List defectList=defectManager.getDefectListByFilter(userId, filterName, filterValue);
			modelAndView.addObject("defectList", defectList);
		}
		}
		
		if(userId!=null)
		{
		List personalQueryList=defectManager.getQueryListbyQueryType("Personal",userId);
		modelAndView.addObject("personalQueryList", personalQueryList);
		
		//List defectList=defectManager.getDefectListByUserId(userId);
		
		}
		List publicQueryList=defectManager.getQueryListbyQueryType("Public",userId);
		modelAndView.addObject("publicQueryList", publicQueryList);
	
		
		
		return modelAndView;

	}
*/
	
}
