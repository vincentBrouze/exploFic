function expandDir(evt) {
    $('#hier').load('actions.php', 'hier=exp&dir=' + evt.target.dataset.path, 
		    function() {
			$('.expand-dir').click(expandDir);
			$('.ret-dir').click(retDir);
		    });
    return false;
}

function retDir(evt) {    
    $('#hier').load('actions.php', 'hier=ret&dir=' + evt.target.dataset.path, 
		    function() {
			$('.ret-dir').click(retDir);
			$('.expand-dir').click(expandDir);
		    });
    return false;
}

function updateLst(evt) {
    $('#lst').load('actions.php', 'lst&dir=' + evt.target.dataset.path, 
		   function() {
		       $('.update-lst').click(updateLst);
		   });
    return false;
}

function sortLst(evt) {
    $('#lst').load('actions.php', 
		   'lst&dir=' + evt.target.dataset.path + '&tri='+evt.target.dataset.tri, 
		   function() {
		       $('.update-lst').click(updateLst);
		       $('.sort-lst').click(sortLst);
		   });
    return false;
}

function init() {
    /* Actions sur les + et les -*/
    $('.expand-dir').click(expandDir);
    $('.ret-dir').click(retDir);

    /* Actions sur les noms de dossier*/
    $('.update-lst').click(updateLst);
    
    /* Tri */
    $('.sort-lst').click(sortLst);
}

window.onload = init;
