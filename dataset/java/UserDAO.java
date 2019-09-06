package com.defecttracking.user.dao;

import java.util.ArrayList;
import java.util.List;

import javax.jdo.PersistenceManager;
import javax.jdo.Query;

import com.defecttracking.PMF;
import com.defecttracking.project.bean.Project;
import com.defecttracking.user.bean.User;



public class UserDAO {

	

	/**
	 * Create a method to check login
	 * ****************************** * 
	 * @param object of the User class	
	 * @return boolean status
	 */
	
	public boolean checkLogin(User user) {
		boolean status = false;
		String userid = user.getUserId();
		String password = user.getPassword();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		String query = "select from " + User.class.getName()
				+ " where userId=='" + userid + "'";
		List<User> uList = (List<User>) pm.newQuery(query).execute();
		if (!uList.isEmpty()) {
			User user2 = pm.getObjectById(User.class, userid);
			if (user != null) {
				String uid = user2.getUserId();
				String pass = user2.getPassword();
				if (userid.equals(uid) && password.equals(pass)) {
					status = true;
				}
			}
		}

		return status;
	}
	
	/**
	 * Create a method to save a new user
	 * ****************************** * 
	 * @param object of the User class	
	 * @return no return
	 */
	
	public void saveUser(User user)
	{		
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		pm.makePersistent(user);
		pm.close();
	}
	
	
	/**
	 * Create a method to get all user details list
	 * ****************************** * 
	 * @param no parameter
	 * @return List userList
	 */
	
	public List getUserList()
	{		
		List userList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		String query = "select from " + User.class.getName()
		+ " where roleid!=1";
		List<User> uList = (List<User>) pm.newQuery(query).execute();
		for(int i=0;i<uList.size();i++)
		{
			User user=(User)uList.get(i);
		if (!uList.isEmpty()) {
			User user2=pm.getObjectById(User.class,user.getUserId());
			userList.add(user2);
		}
		}	
		return userList;		
	}
	
	
	/**
	 * Create a method to get a selected user details list
	 * ****************************** * 
	 * @param String userid
	 * @return List userList
	 */
	
	public List getUserListById(String userid)
	{		
		List userList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		String query = "select from " + User.class.getName()
		+ " where userId=='" + userid + "'";
		List<User> uList = (List<User>) pm.newQuery(query).execute();
		if (!uList.isEmpty()) {
			User user=pm.getObjectById(User.class,userid);
			userList.add(user);
		}
		return userList;		
	}
	
	
	/**
	 * Create a method to delete a existing user
	 * ****************************** * 
	 * @param String userid	
	 * @return boolean status
	 */
	
	public boolean deleteUser(String userid)
	{
		boolean status=false;
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();
		User user=pm.getObjectById(User.class,userid);	
	    try {
	            pm.deletePersistent(user);
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
	 * user details list by roleid
	 * ****************************** * 
	 * @param String roleid
	 * @return List userList
	 */
	
	public List getUserListByRoleId(String roleid)
	{		
		List userList=new ArrayList();
		PersistenceManager pm = PMF.pmfInstance.getPersistenceManager();		
		String query = "select from " + User.class.getName()
		+ " where roleid==" + roleid + "";
		List<User> uList = (List<User>) pm.newQuery(query).execute();
		for(int i=0;i<uList.size();i++)
		{
			User user=(User)uList.get(i);
		if (!uList.isEmpty()) {
			User user2=pm.getObjectById(User.class,user.getUserId());
			userList.add(user2);
		}
		}	
		return userList;		
	}
	
	
	

}
