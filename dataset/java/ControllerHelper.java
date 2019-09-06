package com.defecttracking.common.helper;

import java.util.List;
import java.util.Map;

import org.springframework.web.servlet.ModelAndView;



/**
 * Class Name: ControllerHelper
 * ********************************************************************************
 * Creation Date : 23/8/2010
 * ******************************************************************************** *
 * Class Description : This class is used pageing of all view documents page
 * ********************************************************************************
 * @author Sudipta Bera
 **********************************************************************************
 * Name				Date				Defect/CR					Description
 * ********************************************************************************
 *
 * 
 */


public class ControllerHelper {

	
	
	/**
	 * Create a method to set the pageindex and no of record in a page 
	 * @param pageIndx 
	 * @param modelAndView  The DB logon user name
	 * @param datalist  The DB logon password
	 * @return void
	 * @throws ReportSDKException
	 * * Name				Date				Defect/CR					Description
 * ********************************************************************************
 * Bishnu			02-02-2010			 XYZ					Modified referenceData()-Add userid into session object
	 */
	
	public static String appurl="";
	public static void setPagingVar(String pageIndx, ModelAndView modelAndView,
			List datalist) {

		int prvIndx = 1;
		int nxtIndx = 1;
		int currentPageIndx = 1;

		boolean prvEnable = false;
		boolean nxtEnable = true;

		boolean isNewestEnabled = false;
		boolean isNewerEnabled = false;
		boolean isOlderEnabled = false;
		boolean isOldestEnabled = false;
		
		final int recordPerPage =3;
		int totalRecord = datalist.size();
		// System.out.println("length "+i);

		int totalpage = 0;
		if (totalRecord % recordPerPage == 0) {
			totalpage = (int) totalRecord / recordPerPage;
		} else {
			totalpage = (int) totalRecord / recordPerPage + 1;
		}
		// Object totalPage = Integer.valueOf(totalpage);

		int firstRecord = 0;
		Object si = Integer.valueOf(firstRecord);
		modelAndView.addObject("startIndex", si);

		Object ei = Integer.valueOf(firstRecord + 1);
		modelAndView.addObject("endIndex", ei);
		int nextRecord = 0;

		if (pageIndx != null) {
			currentPageIndx = Integer.parseInt(pageIndx);
			if (currentPageIndx == 1) {
				prvEnable = false;
			} else {
				prvEnable = true;
			}

			if (currentPageIndx == totalpage) {
				nxtEnable = false;
			} else {
				nxtEnable = true;
			}
			prvIndx = Integer.parseInt(pageIndx);
			nxtIndx = Integer.parseInt(pageIndx);
			if (prvIndx > 1) {
				prvIndx = currentPageIndx - 1;
			}
			if (nxtIndx < totalpage) {
				nxtIndx = currentPageIndx + 1;
			}
			for (int pageNo = 1; pageNo <= totalpage; pageNo++) {
				if (pageIndx.equals(String.valueOf(pageNo))) {
					firstRecord = firstRecord + nextRecord;
					si = Integer.valueOf(firstRecord);
					modelAndView.addObject("startIndex", si);

					ei = Integer.valueOf(firstRecord + recordPerPage - 1);
					modelAndView.addObject("endIndex", ei);
					break;
				}
				nextRecord = nextRecord + recordPerPage;
			}

		}

		int pageInt = 0;
		if (pageIndx != null) {
			pageInt = Integer.parseInt(pageIndx);
		}
		int pageBegin = 1;

		if (pageInt >= 3) {
			pageBegin = pageInt - 2;
		}
		int pageEnd = pageInt + 2;
		if (pageEnd > totalpage) {
			pageEnd = totalpage;
		}

		modelAndView.addObject("totalpage", String.valueOf(totalpage));
		modelAndView.addObject("currentPageIndx", String
				.valueOf(currentPageIndx));
		modelAndView.addObject("prvIndx", String.valueOf(prvIndx));
		modelAndView.addObject("nxtIndx", String.valueOf(nxtIndx));
		modelAndView.addObject("prvEnable", String.valueOf(prvEnable));
		modelAndView.addObject("nxtEnable", String.valueOf(nxtEnable));

		modelAndView.addObject("pageBegin", String.valueOf(pageBegin));
		modelAndView.addObject("pageEnd", String.valueOf(pageEnd));

		// modified
		String pagingMsg = null;
		int pageFirstRecord = recordPerPage * (currentPageIndx - 1) + 1;
		int pageLastRecord = recordPerPage * (currentPageIndx - 1)
				+ recordPerPage;
		if (pageLastRecord > totalRecord) {
			pageLastRecord = totalRecord;
		}
		pagingMsg = pageFirstRecord + " - " + pageLastRecord + " of "
				+ totalRecord;

		// enable older and oldest link
		if (totalRecord > pageLastRecord) {
			isOlderEnabled = true;
			if ((totalRecord > 2 * recordPerPage)) {
				isOldestEnabled = true;
			}
		}
		if (currentPageIndx > 1) {
			isNewerEnabled = true;
			if (currentPageIndx > 2) {
				isNewestEnabled = true;
			}
		}

		// enable newer and newest link

		modelAndView.addObject("pagingMsg", pagingMsg);
		modelAndView.addObject("lastIndx", String.valueOf(totalpage));
		modelAndView.addObject("isNewestEnabled", String
				.valueOf(isNewestEnabled));
		modelAndView
				.addObject("isNewerEnabled", String.valueOf(isNewerEnabled));
		modelAndView
				.addObject("isOlderEnabled", String.valueOf(isOlderEnabled));
		modelAndView.addObject("isOldestEnabled", String
				.valueOf(isOldestEnabled));
	}
	
	
	
//	Create a method to set the pageindex and no of record in a page 
	public static void setPagingVar(String pageIndx, Map dataMap,
			List datalist) {

		int prvIndx = 1;
		int nxtIndx = 1;
		int currentPageIndx = 1;

		boolean prvEnable = false;
		boolean nxtEnable = true;

		boolean isNewestEnabled = false;
		boolean isNewerEnabled = false;
		boolean isOlderEnabled = false;
		boolean isOldestEnabled = false;
		//String sql="select value from tblsetings where setingsId='1'";
		String recPerPage="5";
		/*try{
		recPerPage=DWRConnection.retrieveRecord(sql);		
		}
		catch (Exception e) {
			// TODO: handle exception
		}
		*/
		final int recordPerPage = Integer.parseInt(recPerPage);
		int totalRecord = datalist.size();
		// System.out.println("length "+i);

		int totalpage = 0;
		if (totalRecord % recordPerPage == 0) {
			totalpage = (int) totalRecord / recordPerPage;
		} else {
			totalpage = (int) totalRecord / recordPerPage + 1;
		}
		// Object totalPage = Integer.valueOf(totalpage);

		int firstRecord = 0;
		Object si = Integer.valueOf(firstRecord);
		dataMap.put("startIndex", si);

		Object ei = Integer.valueOf(firstRecord + 1);
		dataMap.put("endIndex", ei);
		int nextRecord = 0;

		if (pageIndx != null) {
			currentPageIndx = Integer.parseInt(pageIndx);
			if (currentPageIndx == 1) {
				prvEnable = false;
			} else {
				prvEnable = true;
			}

			if (currentPageIndx == totalpage) {
				nxtEnable = false;
			} else {
				nxtEnable = true;
			}
			prvIndx = Integer.parseInt(pageIndx);
			nxtIndx = Integer.parseInt(pageIndx);
			if (prvIndx > 1) {
				prvIndx = currentPageIndx - 1;
			}
			if (nxtIndx < totalpage) {
				nxtIndx = currentPageIndx + 1;
			}
			for (int pageNo = 1; pageNo <= totalpage; pageNo++) {
				if (pageIndx.equals(String.valueOf(pageNo))) {
					firstRecord = firstRecord + nextRecord;
					si = Integer.valueOf(firstRecord);
					dataMap.put("startIndex", si);

					ei = Integer.valueOf(firstRecord + recordPerPage - 1);
					dataMap.put("endIndex", ei);
					break;
				}
				nextRecord = nextRecord + recordPerPage;
			}

		}

		int pageInt = 0;
		if (pageIndx != null) {
			pageInt = Integer.parseInt(pageIndx);
		}
		int pageBegin = 1;

		if (pageInt >= 3) {
			pageBegin = pageInt - 2;
		}
		int pageEnd = pageInt + 2;
		if (pageEnd > totalpage) {
			pageEnd = totalpage;
		}

		dataMap.put("totalpage", String.valueOf(totalpage));
		dataMap.put("currentPageIndx", String
				.valueOf(currentPageIndx));
		dataMap.put("prvIndx", String.valueOf(prvIndx));
		dataMap.put("nxtIndx", String.valueOf(nxtIndx));
		dataMap.put("prvEnable", String.valueOf(prvEnable));
		dataMap.put("nxtEnable", String.valueOf(nxtEnable));

		dataMap.put("pageBegin", String.valueOf(pageBegin));
		dataMap.put("pageEnd", String.valueOf(pageEnd));

		// modified
		String pagingMsg = null;
		int pageFirstRecord = recordPerPage * (currentPageIndx - 1) + 1;
		int pageLastRecord = recordPerPage * (currentPageIndx - 1)
				+ recordPerPage;
		if (pageLastRecord > totalRecord) {
			pageLastRecord = totalRecord;
		}
		pagingMsg = pageFirstRecord + " - " + pageLastRecord + " of "
				+ totalRecord;

		// enable older and oldest link
		if (totalRecord > pageLastRecord) {
			isOlderEnabled = true;
			if ((totalRecord > 2 * recordPerPage)) {
				isOldestEnabled = true;
			}
		}
		if (currentPageIndx > 1) {
			isNewerEnabled = true;
			if (currentPageIndx > 2) {
				isNewestEnabled = true;
			}
		}

		// enable newer and newest link

		dataMap.put("pagingMsg", pagingMsg);
		dataMap.put("lastIndx", String.valueOf(totalpage));
		dataMap.put("isNewestEnabled", String
				.valueOf(isNewestEnabled));
		dataMap.put("isNewerEnabled", String.valueOf(isNewerEnabled));
		dataMap.put("isOlderEnabled", String.valueOf(isOlderEnabled));
		dataMap.put("isOldestEnabled", String
				.valueOf(isOldestEnabled));
	}
	
	
	
	
	
	
	
}
