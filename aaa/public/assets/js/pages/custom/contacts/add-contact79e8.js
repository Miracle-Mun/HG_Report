"use strict";var KTContactsAdd=function(){var t,e,a,i=[];return{init:function(){t=KTUtil.getById("kt_contact_add"),e=KTUtil.getById("kt_contact_add_form"),(a=new KTWizard(t,{startStep:1,clickableSteps:!0})).on("beforeNext",function(t){i[t.getStep()-1].validate().then(function(t){"Valid"==t?(a.goNext(),KTUtil.scrollTop()):Swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn font-weight-bold btn-light"}}).then(function(){KTUtil.scrollTop()})}),a.stop()}),a.on("change",function(t){KTUtil.scrollTop()}),i.push(FormValidation.formValidation(e,{fields:{firstname:{validators:{notEmpty:{message:"First Name is required"}}},lastname:{validators:{notEmpty:{message:"Last Name is required"}}},companyname:{validators:{notEmpty:{message:"Company Name is required"}}},phone:{validators:{notEmpty:{message:"Phone is required"},phone:{country:"US",message:"The value is not a valid US phone number. (e.g 5554443333)"}}},email:{validators:{notEmpty:{message:"Email is required"},emailAddress:{message:"The value is not a valid email address"}}},companywebsite:{validators:{notEmpty:{message:"Website URL is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),i.push(FormValidation.formValidation(e,{fields:{communication:{validators:{choice:{min:1,message:"Please select at least 1 option"}}},language:{validators:{notEmpty:{message:"Please select a language"}}},timezone:{validators:{notEmpty:{message:"Please select a timezone"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),i.push(FormValidation.formValidation(e,{fields:{address1:{validators:{notEmpty:{message:"Address is required"}}},postcode:{validators:{notEmpty:{message:"Postcode is required"}}},city:{validators:{notEmpty:{message:"City is required"}}},state:{validators:{notEmpty:{message:"state is required"}}},country:{validators:{notEmpty:{message:"Country is required"}}}},plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}})),new KTImageInput("kt_contact_add_avatar")}}}();jQuery(document).ready(function(){KTContactsAdd.init()});