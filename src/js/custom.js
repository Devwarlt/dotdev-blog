const passwordContainsLowercaseLetter = (value) => {
	return /[a-z]/.test(value);
}, passwordContainsUppercaseLetter = (value) => {
	return /[A-Z]/.test(value);
}, passwordContainsSpaces = (value) => {
	return / /.test(value);
}, passwordContainsNumber = (value) => {
	return /[0-9]/.test(value);
}, passwordContainsSymbol = (value) => {
	let containsSymbol = false, symbols = `-!§$%&/()=?.:,~;'#+-/*\\|{}[]_<>"`.split("");
	$.each(symbols, (index, symbol) => {
		if (value.indexOf(symbol) > -1) {
			containsSymbol = true;
			return false;
		}
	});
	return containsSymbol;
}, countSpaces = (value) => {
	return value.split(/ +/).length - 1;
}, toggleAll = (masterBox) => {
	let children = document.getElementsByClassName('checkbox-child');
	for (let i = 0; i < children.length; i++) if (children[i].type === 'checkbox') children[i].checked = masterBox.checked;
}, toggleMaster = () => {
	let masterBox = document.getElementById("checkbox-master");
	let children = document.getElementsByClassName('checkbox-child');
	let countElements = 0;
	$.each(children, (_, child) => {
		if (child.checked) countElements++;
	});
	masterBox.checked = countElements === children.length;
}, updateCheckboxes = (targetBadge, targetButton) => {
	let children = document.getElementsByClassName('checkbox-child');
	let countElements = 0;
	$.each(children, (_, child) => {
		if (child.checked) countElements++;
	});
	if (countElements > 0) {
		targetButton.addClass('btn-primary');
		targetButton.removeClass(['btn-secondary', 'disabled']);
		targetBadge.css('display', 'inline');
	} else {
		targetButton.removeClass('btn-primary');
		targetButton.addClass(['btn-secondary', 'disabled']);
		targetBadge.css('display', 'none');
	}
	targetBadge.html(countElements);
}, passwordInputHandler = (password) => {
	const power = document.getElementById("power-point"), options = {
		"colors": [["bg-light", "muito fraco"], ["bg-secondary", "fraco"], ["bg-info", "normal"], ["bg-success", "forte"], ["bg-warning", "muito forte"], ["bg-danger", "extremamente forte"]],
		"containsLowercaseLetter": 2,
		"containsNumber": 4,
		"containsSymbol": 5,
		"containsUppercaseLetter": 2,
		"cssCustom": "progress-bar bg-secondary rounded-2",
		"cssExtra": "bg-gradient",
		"forEachCharacter": 1,
		"forEachSpace": 1,
		"maxScore": 30
	};

	let score = password.value.length * options.forEachCharacter;
	if (passwordContainsSpaces(password.value)) score += countSpaces(password.value) * options.forEachSpace;
	if (passwordContainsLowercaseLetter(password.value)) score += options.containsLowercaseLetter;
	if (passwordContainsUppercaseLetter(password.value)) score += options.containsUppercaseLetter;
	if (passwordContainsNumber(password.value)) score += options.containsNumber;
	if (passwordContainsSymbol(password.value)) score += options.containsSymbol;

	let rawScore = score / options.maxScore;
	let roundedScore = Math.round(rawScore * 100);
	roundedScore = roundedScore > 100 ? 100 : roundedScore;
	power.ariaValueNow = roundedScore;
	power.style.width = `${roundedScore}%`;

	let adjustedIndexOffset = Math.round(options.colors.length * rawScore);
	adjustedIndexOffset = adjustedIndexOffset >= options.colors.length ? options.colors.length - 1 : adjustedIndexOffset;
	power.className = `${options.cssCustom} ${options.colors[adjustedIndexOffset][0]} ${options.cssExtra}`;
	power.innerHTML = options.colors[adjustedIndexOffset][1];
}, scoreHandler = (powerId, score) => {
	const power = document.getElementById(powerId), options = {
		"colors": ["bg-danger", "bg-warning", "bg-secondary", "bg-info", "bg-primary", "bg-success"],
		"cssCustom": "border-2 d-inline progress-bar progress-bar-animated progress-bar-striped rounded-2",
		"maxScore": 5.00,
		"minScorePercentage": 17.5
	};

	let parsedScore = parseFloat(score);
	let rawScore = parsedScore / options.maxScore;
	let roundedScore = Math.round(rawScore * 100);
	roundedScore = roundedScore > 100 ? 100 : roundedScore;
	if (roundedScore < options.minScorePercentage) roundedScore = options.minScorePercentage;
	power.ariaValueNow = roundedScore;
	power.style.width = `${roundedScore}%`;
	power.style.verticalAlign = "middle";

	let adjustedIndexOffset = Math.round(options.colors.length * rawScore);
	adjustedIndexOffset = adjustedIndexOffset >= options.colors.length ? options.colors.length - 1 : adjustedIndexOffset;
	power.className = `${options.cssCustom} ${options.colors[adjustedIndexOffset]}`;
	power.innerHTML = `${parsedScore.toLocaleString("en", {minimumFractionDigits: 2})} de 
		${options.maxScore.toLocaleString("en", {minimumFractionDigits: 2})} 
		<span class="small glyphicon glyphicon-star"></span>`;
}, removeCookieByName = (name) => {
	document.cookie = `${name}=; Path=/; Max-Age=0;`;
};
