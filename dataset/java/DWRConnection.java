package com.defecttracking.connection;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;


import com.defecttracking.defect.command.Column;
import com.sun.org.apache.bcel.internal.generic.RETURN;



/**
 * Class Name: DWRConnection
 * ********************************************************************************
 * Class Description : This class is used create JDBC connection withe MySql database execute quary using DWR
 * ********************************************************************************
 * @author Sudipta Bera
 **********************************************************************************
 * Name				Date				Defect/CR					Description
 * ********************************************************************************
 * Bishnu			02-02-2010			 XYZ					Modified referenceData()-Add userid into session object
 * 
 */

public class DWRConnection {

	/**
	 * Connnection with MySql using jdbc driver
	 * ****************************** 
	 * @return Connection String
	 */
	
	private static Connection getConnection() {
		Connection con = null;
		String driver = "com.mysql.jdbc.Driver";
		String url = "jdbc:mysql://localhost:3306/dbdefecttracking?user=root&password=admin";
		try {
			Class.forName(driver).newInstance();

			con = DriverManager.getConnection(url);
		} catch (Exception e) {
			System.out.println("Not Connected" + e);
		}
		return con;
	}	

	/**
	 * get Statement for execute a sql quary
	 * ******************************
	 * call getConnection() method to get connection string 
	 * @throws Exception
	 */
	
	
	private static Statement getStatement() throws Exception {
		Statement st = null;
		Connection con = getConnection();
		st = con.createStatement();
		return st;
	}

	
	
	/**
	 * get a list of record from data base through sql quary
	 * ******************************
	 * call getStatement() method to execute sql quary 
	 * @param String sql quary
	 * @throws Exception
	 * @return a List of column name list of a table 
	 */

	
	 public static List getColumnNames(String sql) throws Exception {
		 
		 	ResultSet rs = null;
		 	Statement st = getStatement();
		 	List columnList=new ArrayList();
		 	rs = st.executeQuery(sql);
		    if (rs == null) {
		      return null;
		    }
		    ResultSetMetaData rsMetaData = rs.getMetaData();
		    int numberOfColumns = rsMetaData.getColumnCount();

		    // get the column names; column indexes start from 1
		    for (int i = 1; i < numberOfColumns + 1; i++) {
		    	Column col=new Column();
		      String columnName = rsMetaData.getColumnName(i);
		      col.setColumnId(i);
		      col.setColumnName(columnName);
		      columnList.add(col);
		      // Get the name of the column's table name
		     // String tableName = rsMetaData.getTableName(i);
		    //  System.out.println("column name=" + columnName + " table=" + tableName + "");
		    }
		    return columnList;
		  }

}
