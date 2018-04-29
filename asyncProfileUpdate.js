document.getElementById("edit-bio").onclick = editBiography;


var xttpReq = new XMLHttpRequest();
var firstFeedbackMessage = true;

var bioElement = document.getElementById("bio");
var bioText = document.getElementById("bio-text").innerHTML;


function editBiography() {
	bioElement.innerHTML = "<div class=\"input-group\"><textarea id=\"bio-input\" class=\"form-control\" rows=\"1\">" +
	bioText + "</textarea> <span class=\"input-group-btn\"><button id=\"update-bio\" class=\"btn btn-default\" type=\"button\">Done</button></span></div>";
	document.getElementById("update-bio").onclick = updateBiography;
	console.log(document.getElementById("update-bio").onclick);
}

function updateBiography() {
	var targetScript = "asyncFormHandler.php";
	// could maybe use value here for more secure purposes
	var input = document.getElementById("bio-input").value;
	if (!validateInput(input)) {
		/* provide invalid feedback */ 
		bioElement.innerHTML = "<div class=\"input-group\"><textarea id=\"bio-input\" class=\"form-control is-invalid\" rows=\"1\">" +
		input + "</textarea> <span class=\"input-group-btn\"><button id=\"update-bio\" class=\"btn btn-default is-invalid\" type=\"button\">Done</button></span></div>" +
		"<div class=\"invalid-feedback\">Bio has 140 character limit and prohibits '}', '{', ';'</div>";
		document.getElementById("update-bio").onclick = updateBiography;
	} else {
		targetScript += "?bio=" + input;
	    /* adding random value to url to avoid cache */
	    var randomValueToAvoidCache = (new Date()).getTime();
	    targetScript += "&randomValue=" + randomValueToAvoidCache;

	    xttpReq.open("GET", targetScript, true);
	    /* setting the function that takes care of the request */
	    xttpReq.onreadystatechange = processProgress;
	    /* sending request */
	    xttpReq.send(null);
	}
}

function validateInput(str) {
	let specialChars = ["}", "{", ";"];
	for (let char of specialChars) {
		if (str.includes(char))
			return false;
	}
	return (str.length <= 140);
}

function processProgress() {
    if (xttpReq.readyState === 4) {
        if (xttpReq.status === 200) {
            /* retrieving response */
            var results = xttpReq.responseText;
            if (results !== "ERROR") {
            	// restore elements with new biography text
            	bioElement.innerHTML = "<em id=\"bio-text\">" + results + "</em><span id=\"edit-bio\" class=\"glyphicon glyphicon-pencil\"></span>";
            	bioText = results;
            	document.getElementById("edit-bio").onclick = editBiography;
            }
            
        } else {
           alert("Request Failed.");
        }
    }
}

