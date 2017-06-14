var Aflatpickr = {
	weekdays: {
		shorthand: ["Po", "Ut", "St", "Št", "Pia", "So", "Ne"],
		longhand: ["Pondelok", "Utorok", "Strdeda", "Štvrtok", "Piatok", "Sobota", "Nedela"]
	},
	months: {
		shorthand: ["Jan", "Feb", "Mar", "Apr", "Máj", "Jùn", "Júl", "Aug", "Sep", "Okt", "Nov", "Dec"],
		longhand: ["Január", "Február", "Marec", "Apríl", "Máy", "Jún", "Júl", "August", "September", "Október", "November", "December"]
	},
	daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
	firstDayOfWeek: 0,
	ordinal: function ordinal(nth) {
		var s = nth % 100;
		if (s > 3 && s < 21) return ".";
		switch (s % 10) {
			case 1:
				return ".";
			case 2:
				return ".";
			case 3:
				return ".";
			default:
				return ".";
		}
	},
	rangeSeparator: " do ",
	weekAbbreviation: "týž.",
	scrollTitle: "Použite koliesko myši na zvýšenie hodnoty",
	toggleTitle: "Kliknite na prepnutie"
};
