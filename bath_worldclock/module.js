//Javascript file for world clock
M.WorldClock = M.WorldClock || {};
M.WorldClock.init = function(Y){
	
	YUI().use('dd-constrain', 'dd-proxy', 'dd-drop', function(Y) {
		
	var lis = Y.Node.all('#block_worldclock ul li');
	lis.each(function(v,k){
		var dd = new Y.DD.Drag({
        node: v,
        //Make it Drop target and pass this config to the Drop constructor
        target: {
            padding: '0 0 0 20'
        }
    }).plug(Y.Plugin.DDProxy, {
        //Don't move the node at the end of the drag
        moveOnEnd: false
    }).plug(Y.Plugin.DDConstrained, {
        //Keep it inside the #play node
        constrain2node: '#block_worldclock'
    	});
	});
	 
	var ul = Y.one('#clocklist');
	var target = new Y.DD.Drop({
		node : ul
	});
	Y.DD.DDM.on('drag:start', function(e) {
		var drag = e.target;
		drag.get('node').setStyle('opacity', '.65');
		drag.get('node').setStyle('border-style','dashed');
    	drag.get('dragNode').set('innerHTML', drag.get('node').get('innerHTML'));
    	drag.get('dragNode').setStyles({
        opacity: '.5',
        borderColor: drag.get('node').getStyle('borderColor'),
        backgroundColor: drag.get('node').getStyle('backgroundColor')
   		 });
	});
	Y.DD.DDM.on('drag:end', function(e) {
    var drag = e.target;
    //Put our styles back
    drag.get('node').setStyles({
        visibility: '',
        opacity: '1',
        border: '1px solid #EEE'
    });
});
//Static Vars
    var goingUp = false, lastY = 0;
Y.DD.DDM.on('drag:drag', function(e) {
    //Get the last y point
    var y = e.target.lastXY[1];
    console.log(y);
    //is it greater than the lastY var?
    if (y < lastY) {
        //We are going up
        goingUp = true;
    } else {
        //We are going down.
        goingUp = false;
    }
    console.log('LASTY is:'+lastY);
    //Cache for next check
    lastY = y;
});

Y.DD.DDM.on('drop:over', function(e) {
    //Get a reference to our drag and drop nodes
    var drag = e.drag.get('node'),
        drop = e.drop.get('node');
    
    //Are we dropping on a li node?
    if (drop.get('tagName').toLowerCase() === 'li') {
        //Are we not going up?
        if (!goingUp) {
            drop = drop.get('nextSibling');
        }
        //Add the node to this list
        e.drop.get('node').get('parentNode').insertBefore(drag, drop);
        //Resize this nodes shim, so we can drop on it later.
        e.drop.sizeShim();
    }
});
Y.DD.DDM.on('drag:drophit', function(e) {
    var drop = e.drop.get('node'),
        drag = e.drag.get('node');

    //if we are not on an li, we must have been dropped on a ul
    if (drop.get('tagName').toLowerCase() !== 'li') {
        if (!drop.contains(drag)) {
            drop.appendChild(drag);

        }
    }
                console.log('Dropping finished..now ajax');
});

});
	
}
