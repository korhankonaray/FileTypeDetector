package com.defecttracking.project.dao;

import java.util.ArrayList;
import java.util.List;

import javax.jdo.PersistenceManager;
import javax.jdo.Query;

import com.defecttracking.PMF;
import com.defecttracking.defect.bean.Defect;
import com.defecttracking.project.bean.Project;




public class ProjectDAO {

	

	/**
	 * Create a method to save a new Project
	 * ****************************** * 
	 * @param object of the Project class	
	 * @return no return
	 */
	
	public void saveProject(Project project)
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		pm.makePersistent(project);
		pm.close();
	}
	
	
	/**
	 * Create a method to get all Project details list
	 * ****************************** * 
	 * @param no parameter
	 * @return List projectList
	 */
	
	public List getProjectList()
	{		
		List projectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		/*Query quary=pm.newQuery(Project.class);
		List<Project> projectList=(List<Project>)quary.execute();*/
		
		String query = "select from " + Project.class.getName()
		+ " ORDER BY projectCode";
		List<Project> pList = (List<Project>) pm.newQuery(query).execute();
		for(int i=0;i<pList.size();i++)
		{
			Project project=(Project)pList.get(i);
		if (!pList.isEmpty()) {
			Project project2=pm.getObjectById(Project.class,project.getProjectId());
			projectList.add(project2);
		}
		}
		return projectList;		
	}
	
	
	/**
	 * Create a method to get a selected Project details list
	 * ****************************** * 
	 * @param String projectid
	 * @return List projectList
	 */
	
	public List getProjectListById(String projectid)
	{		
		List projectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();			
		Project project=pm.getObjectById(Project.class,Long.parseLong(projectid));
		projectList.add(project);		
		return projectList;		
	}
	
	
	/**
	 * Create a method to delete a existing Project
	 * ****************************** * 
	 * @param String projectid	
	 * @return boolean status
	 */
	
	public boolean deleteProject(String projectid)
	{
		boolean status=false;
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		Project project=pm.getObjectById(Project.class,Long.parseLong(projectid));	
	    try {
	            pm.deletePersistent(project);
	            status=true;
	      
	    } catch (Exception ex) {
	   	    	System.out.println("Exception "+ex);
	   	    	status=false;
	    } finally {
	      pm.close();
	    } 
	    return status;
	}
	
	
	/**
	 * Create a method to get a selected 
	 * project details list by projectId
	 * ****************************** * 
	 * @param String projectId
	 * @return List projectList
	 */
	
	public List getProjectListByProjectCode(String projectCode)
	{		
		List projectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();	
		String query = "select from " + Project.class.getName()
		+ " where projectCode=='" + projectCode + "'";
		List<Project> pList = (List<Project>) pm.newQuery(query).execute();
		for(int i=0;i<pList.size();i++)
		{
			Project project=(Project)pList.get(i);
		if (!pList.isEmpty()) {
			Project project2=pm.getObjectById(Project.class,project.getProjectId());
			projectList.add(project2);
		}
		}
		return projectList;		
	}
	
	
	

}
