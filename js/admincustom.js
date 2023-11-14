var warehouse_id;
var itemsArray = [];
var random = new Date();
var randomValue = random.getTime();

function showAddItem(){
	var val=document.getElementById("warehouse").selectedIndex;
	if(val == ""){
		$("#itemField").addClass('hidden');
		$("#addField").addClass('hidden');
	}
	else{
		$("#itemField").removeClass('hidden');
		$("#addField").removeClass('hidden');
		warehouse_id = $('#warehouse').val();
        $('#itemField').html('<div style="clear:both;"><span id="formloc1" ><input class="form-group form-control packageName" id="name-1" type="text" name="itemName[]" placeholder="Item Name" style="width:335px;" /><input class="form-group packageQty" id="qty1" type="number" name="itemQty[]" placeholder="Qty" size="4"  style="width:70px;" /><input class="form-group packageID" id="itemid1" type="hidden" value="" name="itemId[]" required="required" /><span style="cursor:pointer;" onclick="removeItem(1)" ><button type="button" class="btn btn-xs btn-danger btn-lg"><i class="fa fa-times"></i>   </button></span></span></div>');
        formid = 1;
        
        jautocomplete('name-1','itemid1', 'qty1', '../controller/admin/ajax/autoComplete.php?random='+randomValue); //package add, item autocomplete
        jQuery("#name-1").keydown(function(e){
            var keycode =  e.keyCode ? e.keyCode : e.which;
    if(keycode == 8 || keycode == 46){ // delete
        removeItemId(1);
    } 

});
    }
}
$("#addField").click(function() {
	$("#itemField").append(addField());
});
var formid = 1;
function addField() {
    formid++;
    $('#itemField').append('<div style="clear:both;"><span id="formloc' + formid + '" ><input id="name-' + formid + '" class="form-group packageName" type="text" name="itemName[]" placeholder="Item Name" style="width:335px;" /><input id="qty' + formid + '" class="form-group form-control packageQty" type="number" name="itemQty[]" placeholder="Qty" size="4" style="width:70px;" /><input id="itemid' + formid + '" class="form-group packageID" type="hidden" value="" name="itemId[]" /><span style="cursor:pointer;" onclick="removeItem(' + formid + ')" ><button type="button" class="btn btn-xs btn-danger btn-lg"><i class="fa fa-times"></i>   </button></span></span></div>');
    jautocomplete('name-' + formid,'itemid' + formid, 'qty' + formid, '../controller/admin/ajax/autoComplete.php?random='+randomValue);
    jQuery("#name-" + formid).bind('keydown',function(e){
        var id = this.id;
        id = id.substring(id.indexOf('-') + 1);
        var keycode =  e.keyCode ? e.keyCode : e.which;
    if(keycode == 8 || keycode == 46){ // delete
     removeItemId(id);
 } 

});
}

function removeItem(formID) {
    $('#formloc' + formID).remove();
}
function jautocomplete(fieldID,responseID,packageQty,ajaxURL) {
        $('#'+fieldID).autocomplete({
        delay:0,
                source: function(request, response) {
            $.ajax({
                url: ajaxURL,
                dataType: "json",
                type: "post",
                data: {
                    term: request.term,
                    wid: warehouse_id
                },
                success: function(data) {
                    response($.map(data, function(item) {
                     if(!in_array(item.item_id, itemsArray)) {       
                        return {   
                            label: item.item_name,
                            item_id: item.item_id,
                            item_qty: item.item_qty
                        }
                    }
                }))
                }
            })
        },
        select: function(event, ui) {
            var value = {};
            value['object_id'] = ui.item.item_id;
            value['object_name'] = ui.item.label;
            value['object_name'] = ui.item.item_qty;
            $('#'+fieldID).attr('value', value);
            $('#'+responseID).attr('value', ui.item.item_id);
            $('#'+packageQty).attr('value', ui.item.item_qty);
            // $('#'+packageQty).attr('max', ui.item.item_qty);
            itemsArray.push(ui.item.item_id);
            return true;
        }
    });
}

function volunter_name_autocomplete() {
        $('#volunterAutocomplete').autocomplete({
        delay:0,
                source: function(request, response) {
            $.ajax({
                url: '../controller/admin/ajax/volunterAutocomplete.php',
                dataType: "json",
                type: "post",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {            
                            label: item.agent_name + "(" + item.agent_id + ")",
                            item_id: item.agent_id
                        }
                    }))
                }
            })
        },
        select: function(event, ui) {
            var value = {'object_name': ui.item.label, object_d: ui.item.item_id};
            $('#volunterAutocomplete').attr('value', value);
            $('#volunteerid').attr('value', ui.item.item_id);
            return true;
        }
    });
}

function package_location_autocomplete() {
        $('#victimzoneAutocomplete').autocomplete({
        delay:0,
                source: function(request, response) {
            $.ajax({
                url: '../controller/admin/ajax/affectedAutocomplete.php',
                dataType: "json",
                type: "post",
                data: {
                    term: request.term
                },
                success: function(data) {
                    console.log(data);
                    response($.map(data, function(item) {
                        return {            
                            label: item.help_call_name + ", " + item.help_call_location + " (" + item.help_call_id + ")",
                            item_id: item.help_call_id,
                            item_latlng: item.help_call_latlng,
                            // place: item.help_call_location
                        }

                    }))
                }
            })
        },
        select: function(event, ui) {
            var value = {'object_name': ui.item.label, object_d: ui.item.item_id};
            
            setMarker(ui.item.item_latlng)
            console.log(ui.item.item_latlng);
            $('#volunterAutocomplete').attr('value', value);
            $('#victim_zone_id').attr('value',ui.item.item_id);
            $('#lat_lng').val(ui.item.item_latlng);
            return true;
        }
    });
}
$(document).ready(function(){
    volunter_name_autocomplete(); //package add volunter name autocomplete
    package_location_autocomplete(); //package add, location autocomplete
});
function setMarker(latlng){
    var locArr = latlng.split(',') 
    marker.setLatLng(locArr);
    map.setView(locArr);
}

function in_array(value, array) {
    var key = 0;
    for (key in array) {
        if (array[key] == value) {
            return true;
        }
    }
    return false;
}

function setSelected(selectid, ID) {
    $('#' + selectid + ' option').eq(ID).attr('selected', true);
}


function removeItemId(id) {
   for(var i in itemsArray){
    
    if(itemsArray[i]==$("#itemid" + id).val()){
        itemsArray.splice(i,1);
        $("#qty" + id).val('');
        break;
    }
}
}
