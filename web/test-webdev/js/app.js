var images = {
	man: {
		heading: 'Man Image',
		description: 'Image of a man.',
		path: 'images/man.jpg'
	},
	wizard: {
		heading: 'Wizard Image',
		description: 'Image of a wizard.',
		path: 'images/wizard.jpg'
	},
	beast: {
		heading: 'Beast Image',
		description: 'Image of a beast.',
		path: 'images/beast.jpg'
	}
};

// Looping through the images object
for (var key in images) {
		// Getting the html div id
		var div = document.getElementById( 'picture-container' );

		// Assigning the different value for each images
    var path = images[key].path;
		var heading = images[key].heading;
		var description = images[key].description;

		// Creating the HTML tags to insert
			var image = '<div class="container">' +
										'<img src="' + path + '" class="img crop" alt="' + description + '" />' +
										'<div class="overlay">' +
											'<div class="title"> ' + heading + '</div>' +
											'<div class="description">' + description + '</div>' +
										'</div>' +
									'</div>';
		div.innerHTML += image;
}
