function initiateUpload()
{

	var chooseHiddenButton = document.getElementById("file");
	chooseHiddenButton.click();
}
function init()
{
	var chooseButton = document.getElementById("chooseButton");
	chooseButton.onclick=initiateUpload;

}

window.onload=init;