' getStatus.vbs --  Not sure what I'll do with this
'
' Run this script on the command line With:
'   cscript.exe //nologo getStatus_WinHttp.vbs
'
' 2012, John A Hamilton is YoYo-Pete, http://yoyo-pete.com
'
'
login_email =    "you@email.com"
login_password = "password"
login_twine =    "00001a111a111a11"

url_login = "https://twine.supermechanical.com/login"
url_data = "https://twine.supermechanical.com/rt/" + login_twine + "?cached=1"

Set Http = CreateObject("MSXML2.ServerXMLHTTP")
'Http.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
Http.Open "POST",url_login,True

Http.send "email=" + login_email + "&password=" + login_password

xmlhttp.waitForResponse 1
wscript.echo Http.ResponseText    'ResponseText returns the response HTML code in text format

