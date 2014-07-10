Validation.add('validate-datetime', 'Please enter a valid date with time. In format YYYY-MM-DD HH:MM:SS', function (v) {
	if (Validation.get('IsEmpty').test(v)) {
		return true;
	}
	var parts = v.split(' ');

	if (parts.length != 2) {
		return false;
	}
	var test = new Date(parts[0]);

	var timeParts = parts[1].split(':');

	if (timeParts.length != 3) {
		return false;
	}

	test.setHours(timeParts[0], timeParts[1], timeParts[2]);

	if (isNaN(test)) {
		return false;
	}

	if (test.getHours() != timeParts[0] || test.getMinutes() != timeParts[1] || test.getSeconds() != timeParts[2]) {
		return false;
	}

	return true;
});