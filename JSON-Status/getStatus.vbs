' getStatus.vbs --  Not sure what I'll do with this
'
' Run this script on the command line With:
'   cscript.exe //nologo getStatus.vbs
'
' 2012, John A Hamilton is YoYo-Pete, http://yoyo-pete.com
'
'
login_email =    "you@email.com"
login_password = "password"
login_twine =    "00001a111a111a11"

url_login = "https://twine.supermechanical.com/login"
url_data = "https://twine.supermechanical.com/rt/" + login_twine + "?cached=1"

DIM oIE

Set oIE = CreateObject("InternetExplorer.Application")
oIE.ToolBar = 0
oIE.StatusBar = 1
oIE.Width = 999
oIE.Height = 999
oIE.Left = 0
oIE.Top = 0
oIE.Visible = false


oIE.navigate url_login
Do While oIE.busy = True
  WScript.Sleep 100
Loop


Set UID = oIE.document.all.email
UID.value = login_email

Set PWD = oIE.document.all.password
PWD.value = login_password

oIE.document.all.signin.click
Do While oIE.busy = True
  WScript.Sleep 100
Loop
wscript.echo oIE.document.title

oIE.navigate url_data
Do While oIE.busy = True
  WScript.Sleep 100
Loop
'If title is not null, then not on JSON page

json_data = oIE.document.Body.InnerHTML
'Parse JSON here

wscript.echo  json_data

oIE.quit