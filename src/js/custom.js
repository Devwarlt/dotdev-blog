const passwordContainsLowercaseLetter = (value) => {
    return /[a-z]/.test(value);
}, passwordContainsUppercaseLetter = (value) => {
    return /[A-Z]/.test(value);
}, passwordContainsSpaces = (value) => {
    return / /.test(value);
}, passwordContainsNumber = (value) => {
    return /[0-9]/.test(value);
}, passwordContainsSymbol = (value) => {
    let containsSymbol = false, symbols = "-!§$%&/()=?.:,~;'#+-/*\\|{}[]_<>\"".split("");
    $.each(symbols, function (index, symbol) {
        if (value.indexOf(symbol) > -1) {
            containsSymbol = true;
            return false;
        }
    });
    return containsSymbol;
}, countSpaces = (value) => {
    return value.split(/ +/).length - 1;
}, toggleAll = (masterBox) => {
    let checkBoxes = document.getElementsByTagName('input');
    for (let i = 0; i < checkBoxes.length; i++)
        if (checkBoxes[i].className.includes('checkbox-child'))
            checkBoxes[i].checked = masterBox.checked;
}, passwordInputHandler = (password) => {
    const power = document.getElementById("power-point"), options = {
        cssCustom: "progress-bar bg-secondary rounded-2",
        cssExtra: "bg-gradient",
        maxScore: 30,
        forEachCharacter: 1,
        forEachSpace: 1,
        containsLowercaseLetter: 2,
        containsUppercaseLetter: 2,
        containsNumber: 4,
        containsSymbol: 5,
        colors: [
            ["bg-light", "muito fraco"],
            ["bg-secondary", "fraco"],
            ["bg-info", "normal"],
            ["bg-success", "forte"],
            ["bg-warning", "muito forte"],
            ["bg-danger", "extremamente forte"]
        ]
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
    adjustedIndexOffset = adjustedIndexOffset >= options.colors.length
        ? options.colors.length - 1 : adjustedIndexOffset;
    power.className = `${options.cssCustom} ${options.colors[adjustedIndexOffset][0]} ${options.cssExtra}`;
    power.innerHTML = options.colors[adjustedIndexOffset][1];
}, fetchCookieByName = (name) => {
    return document.cookie.split("; ").find((row) => row.startsWith(`${name}=`))?.split("=")[1];
}, removeCookieByName = (name) => {
    document.cookie = name + '=; Path=/; Max-Age=0;';
};