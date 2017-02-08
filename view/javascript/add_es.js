/**
 * 
 */

$(document).ready(function () {

    $('#objet_id').change(function () {
        console.log('change');
        var idObjet = $('#objet_id').val();
        console.log(idObjet);

        $.ajax({
            method: 'POST',
            url: "/controller/ajax/Return_SousObjets.php",
            dataType : 'json',
            data: {
                idObjet: idObjet
            },
        })
                .done(function (data) {
                    var sousObjetsSelect = $('#sousobjet_id');
                    sousObjetsSelect.html('');
                    sousObjetsSelect.append($("<option />").val(0).text("---"));
                    $.each(data, function () {
                        // ici, c'est "un objet"
                    	sousObjetsSelect.append($("<option />").val(this.id).text(this.label));
                    });
                });
    });
    
});