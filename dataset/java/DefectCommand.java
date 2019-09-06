package com.defecttracking.defect.command;

import java.util.List;

public class DefectCommand {

	
	private Long defectId;
	
	private String userId=null;
	
	private String usreName=null;
	
	private String headLine=null;
	
	private String state=null;
	
	private String severity=null;
	
	private String project=null;
	
	private String environment=null;
	
	private String priority=null;
	
	private String resolutionGroup=null;
	
	private String testPhase=null;
	
	private String submitterId=null;
	
	private String submitterName=null;
	
	private String submittedDate=null;
	
	private String qualityCenterRef =null;
	
	private String remedyRef=null;
	
	private String crType=null;
	
	private String qualitedInVersion =null;
	
	private String areaAffected=null;
	
	private String description=null;
	
	private List defectNotes=null;
	
	private List defectHistory=null;
	
	private String notes=null;
	

	public String getAreaAffected() {
		return areaAffected;
	}

	public void setAreaAffected(String areaAffected) {
		this.areaAffected = areaAffected;
	}

	public String getCrType() {
		return crType;
	}

	public void setCrType(String crType) {
		this.crType = crType;
	}	

	public Long getDefectId() {
		return defectId;
	}

	public void setDefectId(Long defectId) {
		this.defectId = defectId;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public String getEnvironment() {
		return environment;
	}

	public void setEnvironment(String environment) {
		this.environment = environment;
	}

	public String getHeadLine() {
		return headLine;
	}

	public void setHeadLine(String headLine) {
		this.headLine = headLine;
	}

	public String getPriority() {
		return priority;
	}

	public void setPriority(String priority) {
		this.priority = priority;
	}

	public String getProject() {
		return project;
	}

	public void setProject(String project) {
		this.project = project;
	}

	public String getQualitedInVersion() {
		return qualitedInVersion;
	}

	public void setQualitedInVersion(String qualitedInVersion) {
		this.qualitedInVersion = qualitedInVersion;
	}

	public String getQualityCenterRef() {
		return qualityCenterRef;
	}

	public void setQualityCenterRef(String qualityCenterRef) {
		this.qualityCenterRef = qualityCenterRef;
	}

	public String getRemedyRef() {
		return remedyRef;
	}

	public void setRemedyRef(String remedyRef) {
		this.remedyRef = remedyRef;
	}

	public String getResolutionGroup() {
		return resolutionGroup;
	}

	public void setResolutionGroup(String resolutionGroup) {
		this.resolutionGroup = resolutionGroup;
	}

	public String getSeverity() {
		return severity;
	}

	public void setSeverity(String severity) {
		this.severity = severity;
	}

	public String getState() {
		return state;
	}

	public void setState(String state) {
		this.state = state;
	}

	public String getSubmittedDate() {
		return submittedDate;
	}

	public void setSubmittedDate(String submittedDate) {
		this.submittedDate = submittedDate;
	}

	public String getSubmitterId() {
		return submitterId;
	}

	public void setSubmitterId(String submitterId) {
		this.submitterId = submitterId;
	}

	public String getSubmitterName() {
		return submitterName;
	}

	public void setSubmitterName(String submitterName) {
		this.submitterName = submitterName;
	}

	public String getTestPhase() {
		return testPhase;
	}

	public void setTestPhase(String testPhase) {
		this.testPhase = testPhase;
	}

	public String getUserId() {
		return userId;
	}

	public void setUserId(String userId) {
		this.userId = userId;
	}

	public String getUsreName() {
		return usreName;
	}

	public void setUsreName(String usreName) {
		this.usreName = usreName;
	}
	

	public List getDefectHistory() {
		return defectHistory;
	}

	public void setDefectHistory(List defectHistory) {
		this.defectHistory = defectHistory;
	}

	public List getDefectNotes() {
		return defectNotes;
	}

	public void setDefectNotes(List defectNotes) {
		this.defectNotes = defectNotes;
	}

	public String getNotes() {
		return notes;
	}

	public void setNotes(String notes) {
		this.notes = notes;
	}
	
	
	
	
}
