package com.defecttracking.user.validator;

import org.springframework.validation.Errors;
import org.springframework.validation.ValidationUtils;
import org.springframework.validation.Validator;

import com.defecttracking.user.command.UserCommand;



/**
 * Class Name: AddUserValidator
 * ********************************************************************************
 * Class Description : This class is used set validation on add user page
 * ******************************************************************************** *
 * Creation Date : 22/8/2010
 * ******************************************************************************** *
 * 
 * @author Sudipta Bera
* *********************************************************************************
 * Name 		Date			 Defect/CR 					Description
 * ********************************************************************************
 * 
 * 
 */

public class AddUserValidator implements Validator {
	public boolean supports(Class aClass) {
		return UserCommand.class.equals(aClass);
	}

	
	/**
	 * Create a method to validate the add user page
	 * ****************************** * 
	 * @param Object of command class
	 * @param Object of Spring Error Class
	 * @return no return
	 */
	
	public void validate(Object obj, Errors errors) {
		UserCommand userCommand = (UserCommand) obj;
		
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "userId",
				"field.required", "User Id required");
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "password",
				"field.required", "Password Required");		
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "confpassword",
				"field.required", "Confirm Password Required");
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "fullName",
				"field.required", "User Name Required");			
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "email",
				"field.required", "Email Id Required");	
		ValidationUtils.rejectIfEmptyOrWhitespace(errors, "phone",
				"field.required", "Phone Number required");
		
		if (!errors.hasFieldErrors("password")) {
			 if(userCommand.getPassword().length()<6 || userCommand.getPassword().length()>10 )
			{
				errors.rejectValue("password", "not_zero",
				"Password length should be 6 to 10");
			}
		}
		
		
		if (!errors.hasFieldErrors("password")) {
			if(!userCommand.getPassword().equals(userCommand.getConfpassword()))
				errors.rejectValue("confpassword", "not_zero",
				"Password and Confirm Password should be match");
			}			


			if (!errors.hasFieldErrors("email")) {
				if (!userCommand
						.getEmail()
						.matches(
								"^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$"))
					errors.rejectValue("email", "not_zero",
							"Invalid E-mail Id");
			}

			
			
			if (!errors.hasFieldErrors("phone")) {
				if (!userCommand.getPhone().matches(
				"((-|\\+)?[0-9]+(\\.[0-9]+)?)+"))
				{
			errors.rejectValue("phone", "not_zero",
					"Phone Number should be Number");
				}
				else if(userCommand.getPhone().length()!=10)
				{
					errors.rejectValue("phone", "not_zero",
					"Enter valid phone number");
				}
			}
			
			
			
			
		
		
	}
}