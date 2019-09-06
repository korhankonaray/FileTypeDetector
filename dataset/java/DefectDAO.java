package com.defecttracking.defect.dao;

import java.util.ArrayList;
import java.util.List;

import javax.jdo.PersistenceManager;
import javax.jdo.Query;

import com.defecttracking.PMF;
import com.defecttracking.defect.bean.Defect;
import com.defecttracking.defect.bean.Notes;



public class DefectDAO {

	

	/**
	 * Create a method to save a new Defect
	 * ****************************** * 
	 * @param object of the Defect class	
	 * @return no return
	 */
	
	public void saveDefect(Defect defect)
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		pm.makePersistent(defect);
		pm.close();
	}
	
	
	/**
	 * Create a method to get all user details list
	 * ****************************** * 
	 * @param no parameter
	 * @return List userList
	 */
	
	public List getDefectList()
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		Query quary=pm.newQuery(Defect.class);
		List<Defect> defectList=(List<Defect>)quary.execute();
		return defectList;		
	}
	
	
	/**
	 * Create a method to get a selected defect details list
	 * ****************************** * 
	 * @param String defectid
	 * @return List defectList
	 */
	
	public List getDefectListById(String defectId)
	{		
		List defectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		Defect defect=pm.getObjectById(Defect.class,Long.parseLong(defectId));
		defectList.add(defect);		
		return defectList;		
	}
	
	
	
	
	/**
	 * Create a method to get a selected defect details list
	 * ****************************** * 
	 * @param String defectid
	 * @return List defectList
	 */
	
	public String getLastDefectId()
	{			
		String defectId=null;
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		String query = "select from " + Defect.class.getName()
		+ " where defectId==(select max(defectId) from " + Defect.class.getName()
		+ ")";
		List<Defect> dList = (List<Defect>) pm.newQuery(query).execute();
		if (!dList.isEmpty()) {
			List defectList=dList;
			Defect defect=(Defect)defectList.get(defectList.size()-1);
			//System.out.println(defectList.size());
			defectId=String.valueOf(defect.getDefectId());
		}
		return defectId;		
	}
	
	
	/**
	 * Create a method to get a selected 
	 * defect details list by userId
	 * ****************************** * 
	 * @param String userId
	 * @return List defectList
	 */
	
	public List getDefectListByUserId(String userId)
	{		
		List defectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();	
		String query = "select from " + Defect.class.getName()
		+ " where userId=='" + userId + "'";
		List<Defect> dList = (List<Defect>) pm.newQuery(query).execute();
		for(int i=0;i<dList.size();i++)
		{
			Defect defect1=(Defect)dList.get(i);
		if (!dList.isEmpty()) {
			Defect defect=pm.getObjectById(Defect.class,defect1.getDefectId());
			defectList.add(defect);
		}
		}
		return defectList;		
	}
	
	
	
	/**
	 * Create a method to get a selected 
	 * defect details list by projectId
	 * ****************************** * 
	 * @param String projectId
	 * @return List defectList
	 */
	
	public List getDefectListByProjectId(String projectId)
	{		
		List defectList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();	
		String query = "select from " + Defect.class.getName()
		+ " where project=='" + projectId + "'";
		List<Defect> dList = (List<Defect>) pm.newQuery(query).execute();
		for(int i=0;i<dList.size();i++)
		{
			Defect defect1=(Defect)dList.get(i);
		if (!dList.isEmpty()) {
			Defect defect=pm.getObjectById(Defect.class,defect1.getDefectId());
			defectList.add(defect);
		}
		}
		return defectList;		
	}
	
	
	
	
	
	/**
	 * Create a method to save a new Notes
	 * ****************************** * 
	 * @param object of the Notes class	
	 * @return no return
	 */
	
	public void saveNotes(Notes notes)
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		pm.makePersistent(notes);
		pm.close();
	}
	
	
	/**
	 * Create a method to get all user details list
	 * ****************************** * 
	 * @param no parameter
	 * @return List userList
	 */
	
	public List getNotesList()
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		Query quary=pm.newQuery(Notes.class);
		List<Notes> notesList=(List<Notes>)quary.execute();
		return notesList;		
	}
	
	
	/**
	 * Create a method to get a selected Notes details list
	 * ****************************** * 
	 * @param String notesId
	 * @return List notesList
	 */
	
	public List getNotesListById(String notesId)
	{		
		List notesList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		Notes notes=pm.getObjectById(Notes.class,Long.parseLong(notesId));
		notesList.add(notes);		
		return notesList;		
	}
	
	
	/**
	 * Create a method to get a selected 
	 * Notes details list by userId
	 * ****************************** * 
	 * @param String userId
	 * @return List defectList
	 */
	
	public List getNotesListByDefectId(String defectId)
	{		
		List notesList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();	
		String query = "select from " + Notes.class.getName()
		+ " where defectId==" + defectId + "";
		List<Notes> nList = (List<Notes>) pm.newQuery(query).execute();
		for(int i=0;i<nList.size();i++)
		{
			Notes notes=(Notes)nList.get(i);
		if (!nList.isEmpty()) {
			Notes notes2=pm.getObjectById(Notes.class,notes.getNotesId());
			notesList.add(notes2);
		}
		}
		return notesList;		
	}
	
	
	
	
	
	
}
