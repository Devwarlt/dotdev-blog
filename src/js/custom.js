function passwordContainsLowercaseLetter(value) {
    return (/[a-z]/).test(value);
}

function passwordContainsUppercaseLetter(value) {
    return (/[A-Z]/).test(value);
}

function passwordContainsSpaces(value) {
    return (/ /).test(value);
}

function passwordContainsNumber(value) {
    return (/[0-9]/).test(value);
}

function passwordContainsSymbol(value) {
    let containsSymbol = false,
        symbols = "-!§$%&/()=?.:,~;'#+-/*\\|{}[]_<>\"".split("");

    $.each(symbols, function (index, symbol) {
        if (value.indexOf(symbol) > -1) {
            containsSymbol = true;

            // We found a symbol. Therefore, return false to exit $.each early (short-circuit).
            return false;
        }
    });

    return containsSymbol;
}

function countSpaces(value) {
    return value.split(/ +/).length - 1;
}

let password = document.getElementById("password");
let power = document.getElementById("power-point");
password.oninput = function () {
    const options = {
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
};
