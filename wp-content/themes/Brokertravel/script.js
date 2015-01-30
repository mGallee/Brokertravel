var myLanguage = {
      errorTitle : 'Form submission failed!',
      requiredFields : 'Sie Haben nicht alle Mussfelder ausgefüllt!',
      badTime : 'You have not given a correct time',
      badEmail : 'Sie müssen eine korrekte E-Mail Adresse eingeben',
      badTelephone : 'You have not given a correct phone number',
      badSecurityAnswer : 'You have not given a correct answer to the security question',
      badDate : 'You have not given a correct date',
      lengthBadStart : 'You must give an answer between ',
      lengthBadEnd : ' characters',
      lengthTooLongStart : 'You have given an answer longer than ',
      lengthTooShortStart : 'You have given an answer shorter than ',
      notConfirmed : 'Values could not be confirmed',
      badDomain : 'Incorrect domain value',
      badUrl : 'The answer you gave was not a correct URL',
      badCustomVal : 'Das ist keine gültige Eingabe',
      badInt : 'The answer you gave was not a correct number',
      badSecurityNumber : 'Your social security number was incorrect',
      badUKVatAnswer : 'Incorrect UK VAT Number',
      badStrength : 'The password isn\'t strong enough',
      badNumberOfSelectedOptionsStart : 'You have to choose at least ',
      badNumberOfSelectedOptionsEnd : ' answers',
      badAlphaNumeric : 'The answer you gave must contain only alphanumeric characters ',
      badAlphaNumericExtra: ' and ',
      wrongFileSize : 'The file you are trying to upload is too large',
      wrongFileType : 'The file you are trying to upload is of wrong type',
      groupCheckedRangeStart : 'Please choose between ',
      groupCheckedTooFewStart : 'Please choose at least ',
      groupCheckedTooManyStart : 'Please choose a maximum of ',
      groupCheckedEnd : ' item(s)'
};

function formchange(period){
	if(period=="Firma"){
		window.document.getElementById("changeonselect").style.display="block";
	}else{
		window.document.getElementById("changeonselect").style.display="none";
	}
}

$( document ).ready(function() {
    console.log("ready!");
	$(".nav.navbar-nav li").on("mouseover", function(){
		var imagename = $(this).attr("class").split(" ")[1];
		$("header").css("background-image", "url(wp-content/themes/Brokertravel/images/"+imagename+".jpg)");
	});
});
