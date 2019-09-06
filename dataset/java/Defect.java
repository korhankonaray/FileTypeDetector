package com.defecttracking.defect.bean;

import javax.jdo.annotations.IdentityType;
import javax.jdo.annotations.PersistenceCapable;
import javax.jdo.annotations.Persistent;
import javax.jdo.annotations.PrimaryKey;


@PersistenceCapable(identityType=IdentityType.APPLICATION)
public class Defect {

	@PrimaryKey
	private Long defectId;
	@Persistent
	private String userId=null;
	@Persistent
	private String usreName=null;
	@Persistent
	private String headLine=null;
	@Persistent
	private String state=null;
	@Persistent
	private String severity=null;
	@Persistent
	private String project=null;
	@Persistent
	private String projectCode = null;
	@Persistent
	private String projectName=null;	
	@Persistent
	private String environment=null;
	@Persistent
	private String priority=null;
	@Persistent
	private String resolutionGroup=null;
	@Persistent
	private String testPhase=null;
	@Persistent
	private String submitterId=null;
	@Persistent
	private String submitterName=null;
	@Persistent
	private String submittedDate=null;
	@Persistent
	private String qualityCenterRef =null;
	@Persistent
	private String remedyRef=null;
	@Persistent
	private String crType=null;
	@Persistent
	private String qualitedInVersion =null;
	@Persistent
	private String areaAffected=null;
	@Persistent
	private String description=null;
	@Persistent
	private String modifiedby=null;
	@Persistent
	private String modificationdate=null;
	
	

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

	public String getProjectName() {
		return projectName;
	}

	public void setProjectName(String projectName) {
		this.projectName = projectName;
	}

	public String getProjectCode() {
		return projectCode;
	}

	public void setProjectCode(String projectCode) {
		this.projectCode = projectCode;
	}

	public String getModifiedby() {
		return modifiedby;
	}

	public void setModifiedby(String modifiedby) {
		this.modifiedby = modifiedby;
	}

	public String getModificationdate() {
		return modificationdate;
	}

	public void setModificationdate(String modificationdate) {
		this.modificationdate = modificationdate;
	}
	
	
	
	
	
	
}
