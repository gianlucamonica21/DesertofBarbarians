function showModal(id){


	//TO DO QUERY PER FAR SI DI NON DARE PIU VOLTE LO STESSO BADGE
	switch(id){
		case 1:
		{
			console.log("id 1");
			$("#notification-modal-title").text('First Level Gone!');
			$("#modal-text").text('You are at the second level!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 2:
		{
			$("#notification-modal-title").text('Halfway!');
			$("#modal-text").text('You passed level 4!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 3:
		{
			$("#notification-modal-title").text('Indie Programmer!');
			$("#modal-text").text('Hint is not in your vocabolary!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 4:
		{
			$("#notification-modal-title").text('!');
			$("#modal-text").text('!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 5:
		{
			$("#notification-modal-title").text('Champion!');
			$("#modal-text").text('You are the top player of all time!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 6:{
			$("#notification-modal-title").text('Debug!');
			$("#modal-text").text('YOU FINISHED THE DEBUGGING LEVELS!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break
		}
		case 7:
		{
			$("#notification-modal-title").text('Refactoring!');
			$("#modal-text").text('YOU FINISHED THE REFACTORING LEVELS!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 8:
		{
			$("#notification-modal-title").text('Design!');
			$("#modal-text").text('YOU FINISHED THE DESIGNING LEVELS!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		case 9:
		{
			$("#notification-modal-title").text('WAR IS OVER!');
			$("#modal-text").text('YOU FINISHED THE GAME!');
			$("#image-modal").attr('src', 'img/star_badge.png');
			$("#notificationModal").modal('show');
			break;
		}
		default:{}
	}
}

function badge(){
	var badgeQueue = [];
	var unlockedbadgeQueue = [];

	if (document.body.getAttribute("level") == 1 &&
			maxlevel == 1) {
		badgeQueue.push(1);
		unlockedbadgeQueue.push(1);
	}
	if (document.body.getAttribute("level") == 4 &&
			maxlevel == 4) {
		badgeQueue.push(2);
		unlockedbadgeQueue.push(2);
	}
	if (contHint == 0 &&
			ownedBadges.indexOf(3) == -1) {
		badgeQueue.push(3);
		unlockedbadgeQueue.push(3);
	}
	if (champion &&
			ownedBadges.indexOf(5) == -1) {
		badgeQueue.push(5);
		unlockedbadgeQueue.push(5);
	}
	if (document.body.getAttribute("level") == 3 &&
			maxlevel == 3) {
		badgeQueue.push(6);
		unlockedbadgeQueue.push(6);
	}
	if (document.body.getAttribute("level") == 6 &&
	 		maxlevel == 6) {
		badgeQueue.push(7);
		unlockedbadgeQueue.push(7);
	}
	if (document.body.getAttribute("level") == 9 &&
			maxlevel == 9 &&
			ownedBadges.indexOf(9) == -1) {
		badgeQueue.push(8);
		unlockedbadgeQueue.push(8);
		badgeQueue.push(9);
		unlockedbadgeQueue.push(9);
	}
	if (champion &&
			ownedBadges.indexOf(5) == -1) {
		badgeQueue.push(5);
		unlockedbadgeQueue.push(5);
	}
	console.log(badgeQueue);

	if(badgeQueue.length > 0 ){
		showModal(badgeQueue.shift());
	}

	$("#closeModal").click(function() {
		if(badgeQueue.length > 0 ) {
			showModal(badgeQueue.shift());
		}
		else{
			$("#notificationModal").modal('hide');
			//location.reload();
		}
	});

	return unlockedbadgeQueue;
}
