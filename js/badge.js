function showModal(id){


	//TO DO QUERY PER FAR SI DI NON DARE PIU VOLTE LO STESSO BADGE
	switch(id){

		case 1:
		{
		console.log("id 1");
		$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('SECOND LEVEL!');
		$("#image-modal").attr('src', 'img/level2.png');
		$("#notificationModal").modal('show');
		break;}

		case 2:
		{$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU ARE AN HALFWAY THERE!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		break;}
		case 3:
		{
		$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU HAVE PASSED THE LEVEL WITHOUT ANY HINT!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		break;}
		case 4:
		{
		$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU FINISH THE GAME!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		
		break;}
		case 5:
		case 6:
		case 7:
		{$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU FINISHED THE DEBUGGING LEVELS!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		break;}
		case 8:
		{
		$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU FINISHED THE REFACTORING LEVELS!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		break;}
		case 9:
		{
		$("#notification-modal-title").text('NEW BADGE!');
		$("#modal-text").text('YOU FINISHED THE DESIGNING LEVELS!');
		$("#image-modal").attr('src', '');
		$("#notificationModal").modal('show');
		 
		break;}




	}
}



function badge(){

	var badgeQueue = [];
	if (contHint == 0){
		badgeQueue.push(3);
	}
	if (document.body.getAttribute("level") == 1){
		badgeQueue.push(1);
	}
	if (document.body.getAttribute("level") == 4){
		badgeQueue.push(2);
	}
	if (document.body.getAttribute("level") == 9){
		badgeQueue.push(4);
	}
	if (document.body.getAttribute("level") == 3){
		badgeQueue.push(7);
	}
	if (document.body.getAttribute("level") == 6){
		badgeQueue.push(8);
	}
	if (document.body.getAttribute("level") == 9){
		badgeQueue.push(9);
	}

	console.log(badgeQueue);

	if(badgeQueue.length > 0 ){
		showModal(badgeQueue.shift());
	}


	$("#closeModal").click(function() {

		if(badgeQueue.length > 0 ){
			showModal(badgeQueue.shift());
			
		
		}
		else{
			$("#notificationModal").modal('hide');
			location.reload();
		}
	});


}



