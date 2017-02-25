/**
 * 
 */

$(document).ready(function () {
    $('#annee_mens').change(function () {
    	console.log('change');
    	var annee = $('#annee_mens').val();
        console.log(annee);
        $.ajax({
            method: 'POST',
            url: "/controller/ajax/Return_Mois.php",
            dataType : 'json',
            data: {
                annee: annee
            },
        })
                .done(function (data) {
                    var moisSelect = $('#mois');
                    moisSelect.html('');
                    $.each(data, function () {
                        // ici, c'est "une annee"
                    	moisSelect.append($("<option />").val(this.num).text(this.nom));
                    });
                });
    });
    
});