$(document).ready(function () {
    //JS for creating new user
    $("form[name=frmReg").submit(function () {
        var user = $("#user").val();
        var email = $("#email").val();
        var pass = $("#pass").val();
        var passConf = $("#passConf").val();
        var fullName = $("#fName").val();
        var lastName = $("#lName").val();
        var dob = $("#birthday").val();
        var fUser = 0;
        var fEmail = 0;
        var fPass = 0;
        var fPassConf = 0;
        var fFullName = 0;
        var fLastName = 0;
        var fDOB = 0;
        if (isUserName(user)) fUser = 1;
        if (isEmail(email)) fEmail = 1;
        if (isPass(pass)) fPass = 1;
        if (passConf == pass) fPassConf = 1;
        if (isName(fullName)) fFullName = 1;
        if (isName(lastName)) fLastName = 1;
        var y = (new Date(dob)).getFullYear();
        var y_current = (new Date()).getFullYear();
        if ((y_current - y) >= 18) fDOB = 1;
        if (fUser == 1 && fEmail == 1 && fPass == 1 && fPassConf == 1 && fFullName == 1 && fLastName == 1 && fDOB == 1) {
            return true;
        } else if (user == '' && email == '' && pass == '' && passConf == '' && fullName == '' && lastName == '') {
            window.alert('You must fill out the form before submit');
            return false;
        } else {
            if (user == '') errorMess("errUser", "Please enter username");
            else if (fUser == 0) errorMess("errUser", "Invalid, username must not contain special characters (except for .-_ )");
            else errorMess('errUser', '');
            if (email == '') errorMess("errEmail", "Please enter your Email address");
            else if (fEmail == 0) errorMess("errEmail", "Invalid, please check your Email format");
            else errorMess('errEmail', '');
            if (pass == '') errorMess("errPass", "Please enter password");
            else if (fPass == 0) errorMess("errPass", "Password must contain at least 8 characters");
            else errorMess('errPass', '');
            if (passConf == '') errorMess("errPassConf", "Please retype your password");
            else if (fPassConf == 0) errorMess("errPassConf", "Passwords must match");
            else errorMess('errPassConf', '');
            if (fullName == '') errorMess("errFName", "Please enter your first name");
            else if (fFullName == 0) errorMess("errFName", "Invalid, name must not contain special characters (except for .-' ), first character must be capitalized");
            else errorMess('errFName', '');
            if (lastName == '') errorMess("errLName", "Please enter your first name");
            else if (fLastName == 0) errorMess("errLName", "Invalid, name must not contain special characters (except for .-' )");
            else errorMess('errLName', '');
            if (fDOB == 0) errorMess('errBirthday', 'Must be at least 18 years old');
            else errorMess('errBirthday','');
            return false;
        }
    })
    $("form[name=frmProfile]").submit(function(){
        var fPass = 1;
        var fPassConf = 1;
        var fEmail = 1;
        var pass = $("#pass").val();
        var passConf = $("#passConf").val();
        var email = $("#email").val();
        if (email != ''){
            if (!isEmail(email)){
                fEmail = 0;
                errorMess('errEmail', 'Invalid, please check your Email format');
            }else fEmail = 1;
        }
        if (pass != ''){
            if (!isPass(pass)){
                fPass = 0;
                errorMess('errPass', 'Password must not be longer than 8 characters');
            }else if (pass != passConf){
                fPass = 0;
                errorMess("errPass", "Password and Confirmation Password does not match");
            }else{
                fPass = 1;
                errorMess("errPass", "");
            }
        }
        if (fEmail == 1 && fPass == 1 && fPassConf == 1){
            return true;
        }else return false;
    })
    $("form[name=frmReset]").submit(function(){
        var fPass = 1;
        var fPassConf = 1;
        var pass = $("#pass").val();
        var passConf = $("#passConf").val();
        if (pass != ''){
            if (!isPass(pass)){
                fPass = 0;
                errorMess("errPass","Password must not be longer than 8 characters");
            }else{
                fPass = 1;
                errorMess("errPass","");
            }
            if (pass != passConf){
                fPassConf = 0;
                errorMess("errPassConf", "Password and Confirmation Password does not match");
            }else{
                fPassConf = 1;                
                errorMess("errPassConf","");
            }
        }
        if (fPass == 1 && fPassConf == 1){
            return true;
        }else return false;
    })
    //Differentiate between 2 submit buttons on the same form (search and delete)
    $("#btnSearch, #btnDelAll").click(function(){
        if(this.id == 'btnSearch'){
            var s = $("#txtSearch").val();
            s = s.replace(' ','+');
            if (s != ''){
                window.location.href = "?a=users&s="+s+"&page=1";
            }else window.location.href = "?a=users&page=1";
            return false;
        }else{
            if (confirm('Are you sure to delete these records?')){
                return true;
            }else return false;
        }
    })
})

function isUserName(str) {
    var patt = /^[a-zA-Z0-9\_\.\-]*?[a-zA-Z0-9]+[a-zA-Z0-9\_\.\-]*?$/;
    if (str.match(patt)) return true;
    else return false;
}

function isName(str) {
    var patt = /^[A-Z](([a-z]*?(\'|\-|\.)[a-zA-Z][a-z]*?)|([a-z]*?))([ ][A-Z](([a-z]*?(\'|\-|\.)[a-zA-Z][a-z]*?)|([a-z]*?)))*?$/;
    if (str.match(patt)) return true;
    else return false;
}

function isEmail(str) {
    var patt = /^[a-zA-Z0-9]+[a-zA-Z0-9\.\_]*[a-zA-z0-9]+(@)[a-z]+(\.)[a-z]+(\.[a-z]+)*?$/;
    if (str.match(patt)) return true;
    else return false;
}

function isPass(str) {
    var patt = /^.{8}.*$/;
    if (str.match(patt)) return true;
    else return false;
}

function errorMess(_id, _mess) {
    document.getElementById(_id).innerHTML = _mess;
}

function del(_id){
    if (confirm('Are you sure to delete this record?')){
        var url = window.location.href;
        var patt = /(\&s\=){1}.*$/;
        var s = (url.match(/(\&s\=).*?(?=(\&))/))?url.match(/(\&s\=).*?(?=(\&))/)[0]:'';
        if (s.length >0) window.location.href = "?a=delete&m=users"+s+"&id="+_id;
        else window.location.href = "?a=delete&m=users&id="+_id;
    }
}

function checkAll(){
    var ck = $('[name="ck[]"]');
    var ckAll = $("#ckAll")[0];
    if(ck.length > 0){
        if(ckAll.checked == true){
            for(i = 0; i < ck.length; i++){
                ck[i].checked = true;
            }
        }else{
            for(i = 0; i < ck.length; i++){
                ck[i].checked = false;
            }
        }
    }
}