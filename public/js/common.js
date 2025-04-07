
function notify(msg,type,time){
    $.notify({
        message: msg
    },{
        // settings
        type: (type) ? type : 'danger',
        placement: {
            from: "bottom",
            align: "right",
        },
        delay: (typeof(time) != "undefined" && time !== null) ? time : 200,
        z_index: 9999,
    });
}

function generate_notification(message,type){
    var var_type = typeof message;

    if (var_type === 'object') {
        $.each(message, function (i, val) {
            notify(val,type);
        });
    } else {
        notify(message,type);
    }
}

var tableSearchParam;
function loadTable(loadHtml, filterFrm) {
    var frm = $(filterFrm).serialize();
    if (frm == '') {
        const urlParams = new URLSearchParams(window.location.search);
        frm = {status:urlParams.get('status')}
    }

    if(tableSearchParam != frm) {
        tableSearchParam = frm;
        $.ajax({
            type: "POST",
            url: loadTableUrl,
            data: frm,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $(loadHtml).html("<h4 class='text-center'>Loading...</h4>");
            },
            success: function (data) {
                $(loadHtml).html(data);
                $('#datatable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                });
            },
            error: function (xhr, status, result) {
                $(loadHtml).html(result);
            }
        });
    }
}

function loadNotification() {
    $.ajax({
        type: "GET",
        url: loadNotificationUrl,
        dataType:'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // $('#top-notification .dropdown-menu').html("<h4 class='text-center'>Loading...</h4>");
        },
        success: function(data) {
            $('#top-notification .dropdown-menu').html(data.html);
            $('#top-notification .count').text(data.count);
            if (data.count){
                $('#top-notification .count').show();
            } else {
                $('#top-notification .count').hide();
            }
        },
        error: function(xhr, status, result) {
            $('#top-notification .dropdown-menu').html(result.html);
        }
    });
}

function formatRepo(repo) {
    if (repo.loading) return repo.text;
    var markup = "<div class='select2-result-repository clearfix'>" + "<div class='select2-result-repository__meta'>" + "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

    if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" + "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" + "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" + "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" + "</div>" + "</div></div>";
    return markup;
}

function formatRepoSelection(repo) {
    return repo.full_name || repo.text;
}

function select2Option($data) {
    var ajax = {
        url: $data.url,
        dataType: 'json',
        type:"POST",
        delay: 250,
        data: function(params) {
            var $query = {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                search: params.term,
                page: params.page
            };
            // if ("ajax_data" in $data) {
            //     $.extend($query, $data.ajax_data());
            // }

            if (typeof $data.param != "undefined") {
                $query = {...$query, ...$data.param}
            }

            return $query;
        },
        processResults: function(data, params) {

            return {
                results: data.results,
                pagination: {
                    more: data.more
                }
            };
        },
        escapeMarkup: function escapeMarkup(markup) {
            return markup;
        },
        // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        // omitted for brevity, see the source of this page
        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    };


    return {
        placeholder: $data.placeholder,
        width: $( $data.el ).outerWidth(),
        multiple: $data.multiple ? $data.multiple : false,
        allowClear: $data.allowClear ? $data.allowClear : false,
        cache: false,
        ajax: ajax
    }
}

function loadSelect2(ele, url, placeHolder, param) {
    $(ele).select2({
        placeholder: placeHolder,
        ajax: {
            url: url,
            dataType: 'json',
            type:"POST",
            delay: 250,
            data: function(params) {
                var $query = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    search: params.term,
                    page: params.page
                };
                return {
                    ...$query,
                    ...param
                };
                // return $query;
            },
            processResults: function(data, params) {
                return {
                    results: data.results,
                    pagination: {
                        more: data.more
                    }
                };
            },
        }
    });
}

function bindFileUpload() {
    $('.fileupload').fileupload({
        url: tempUploadUrl,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|tiff|bmp|png|svg)$/i,
        dropZone: $('.upload_image_container'),
        pasteZone: null,
        maxFileSize: 30 * 1024 * 1024,
        submit: function (e, data) {
            $(this).closest('.upload-container').append('<div class="progress progress-striped active"><div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div></div>');
        },
        progress: function (e, data) {
            var percent = parseInt(data.loaded / data.total * 100, 10);
            $(this).closest('.upload-container').find(".progress .progress-bar").attr("aria-valuenow", percent).css("width", percent + "%").html(percent + "%");
        },
        done: function (e, data) {
            var result = data._response.result;
            $(this).closest('.image-preview').find('img').attr('src', result.path);
            $(this).closest('.upload-container').find('.field_name').val(result.name);
            $(this).closest('.upload-container').find(".progress").remove();
            $(this).closest('.upload-container').find('.file-preview').find('a').attr('href', result.path);
            $(this).closest('.upload-container').find('.file-preview').find('a').text(result.name);
            $(this).closest('.upload-container').next('.error').html('');
        },
        fail: function (e, data) {
            var result = data._response.jqXHR.responseJSON;
            console.log(result.message)
            $(this).closest('.image-preview').find('img').attr('src', '');
            $(this).closest('.upload-container').find('.field_name').val('');
            $(this).closest('.upload-container').find(".progress").remove();
            $(this).closest('.upload-container').next('.text-danger').text(result.message);
            $(this).closest('.upload-container').find('.file-preview').find('a').attr('href', '');
            $(this).closest('.upload-container').find('.file-preview').find('a').text('');
        }
    }).bind('fileuploadsubmit', function (e, data) {
        data.formData = {
            '_token': $("meta[name='csrf-token']").attr("content")
        };
    });
}

function initDatepicker(el) {
    $(el).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy',
        defaultDate: new Date()
    });
}


function datalistDropdown(inputId){
    id = document.getElementById(inputId);
    datalist = id.nextElementSibling;
    var minWidth = datalist.offsetWidth;


    function outputsize(){
        if (id.offsetWidth < minWidth ){
            datalist.style.minwidth = id.offsetWidth+'px';
        }else{
            datalist.style.width = id.offsetWidth+'px';
        }
    }

    new ResizeObserver(outputsize).observe(id);


    id.addEventListener("input", function(e){
        datalist.style.display = "block";
        var text = id.value.toUpperCase();
        let hide = 1;
        for (let option of datalist.options) {
            if(option.value.toUpperCase().indexOf(text) > -1){
                option.style.display = "block";
                hide = 0;
            }else{
                option.style.display = "none";
            }
        }
        if (hide){
            datalist.style.display = "none";
        }
    });

    id.addEventListener("click", function(e){

        let hide = 1;
        for (let option of datalist.options) {
            if (window.getComputedStyle(option, null).display == "block") hide = 0;
        }

        if (datalist.style.display == "block" || hide == 1){
            datalist.style.display = "none";
        }else{
            datalist.style.display = "block";
        }
    });

    document.addEventListener("click", function(e){

        if (e.target.tagName == "OPTION"){
            id.value = e.target.value;
        }
        if (e.target.tagName !== "DATALIST" && e.target.tagName !== "INPUT"){
            datalist.style.display = "none";
        }

    });

    id.addEventListener('blur', () => {
        setTimeout(() => {
            datalist.style.display = "none";
        }, 100);
    });

    id.addEventListener('focus', () => {
        setTimeout(() => {
            datalist.style.display = "block";
        }, 100);
    });

    datalist.style.display = "none";
}
$(document).ready(function() {

    initDatepicker('.comman-date-picker');

    // $('.date-mask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd/mm/yyyy' })
    // $('[data-mask]').inputmask();

    // on first focus (bubbles up to document), open the menu
    // $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    //   $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    // });

    // // steal focus during close - only capture once and stop propogation
    // $('select.select2').on('select2:closing', function (e) {
    //   $(e.target).data("select2").$selection.one('focus focusin', function (e) {
    //     e.stopPropagation();
    //   });
    // });

    $(document).off('click', '#comman_submit_info, .modal_submit_info').on('click', '#comman_submit_info, .modal_submit_info', function() {
        var btn = $(this);
        var old_val = btn.val();
        var form = btn.closest('form');
        var moduleId = form.find("#moduleId").val();
        var formData = new FormData(form[0]);
        var submitUrl = btn.data('url') ? btn.data('url') : saveUrl;

        $.ajax({
            url: submitUrl,
            type: 'post',
            dataType: 'json',
            // data: form.serialize(),
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function() {
                $('.error,.submit_notification').html('');
                form.find(".form-control").removeClass("red-border");
                $('.btn').attr("disabled", "disabled");
                btn.val("Sending...");
            },
            success: function(result) {
                $('.btn').removeAttr("disabled");
                btn.val(old_val);
                // form.find(':input:enabled:visible:first').focus();
                form.find('input[type=text],textarea,select').filter(':enabled:visible:first').focus();
                form[0].reset();
                form.find('.select2').val('').trigger('change');
                form.find('.submit_notification').html('<span class="text-success error">' + result.message + '</span>');
                btn.closest('.modal').modal('hide');
                notify(result.message,'success',300);

                // if (btn.hasClass('modal_submit_info')) {
                //     type = btn.closest('.modal').find("#modal_type").val();
                //     if ($("#" + type).length) {
                //         $("#" + type).select2('open');
                //     }
                // }
                if (result.redirectTo) {
                    window.location.href = result.redirectTo;
                } else if (result.reload) {
                    window.location.reload();
                } else {
                    // if (moduleId) {
                    //     window.location.href = returnUrl;
                    // } else {
                    //     form[0].reset();
                    //     $('.select2').val('').trigger('change');
                    // }
                    if (result.html) {
                        let appentTo = btn.data('appendto');
                        $(appentTo).append(result.html);
                    }
                }
            },
            error: function(e) {
                $('.btn').removeAttr("disabled");
                btn.val(old_val);

                if (e.status == 422) {
                    $.each(e.responseJSON.errors, function(i, val) {
                        if (val != "") {
                            form.find("#" + i + "_error").text(val);
                            notify(val,'danger',300);
                        }
                    });
                    $("body").animate({
                        scrollTop: 0
                    }, "slow");
                    form.find('.submit_notification').html('<span class="text-danger error">'+e.responseJSON.message+'</span>');
                } else if (e.message || e.responseJSON.message) {
                    form.find('.submit_notification').html('<span class="text-danger error">'+(e.responseJSON.message ? e.responseJSON.message : e.message)+'</span>');
                } else {
                    form.find('.submit_notification').html('<span class="text-danger error">Something Went Wrong!... Please try again after refresh</span>');
                }
            }
        });
    });

    $(document).off('click', '.comman-delete-btn').on('click', '.comman-delete-btn', function (e) {
        e.stopPropagation();
        var btn = $(this);
        bootbox.confirm({
            size: 'small',
            title: "<span class='text-danger'>Alert !</span>",
            message: "Are You Sure You Want to Delete This Record?",
            buttons: {
               cancel: {
                   label: '<i class="fa fa-times"></i> Cancel'
               },
               confirm: {
                   label: '<i class="fa fa-check"></i> Confirm',
                   class: 'btn-danger'
               }
            },
            callback: function (result) {
                if (result) {
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: btn.data('href'),
                        type: 'DELETE',
                        dataType: 'json',
                        data:{'_token' : token},
                        success: function(data) {
                            notify(data.message, 'success');
                            if (data.relaod == true) {
                                window.location.reload();
                            } else {
                                btn.closest('tr').remove();
                            }
                        }, error(e) {
                            notify(e.responseJSON.message, 'danger', 0);
                            // notify('Something went wrong please try again after refresh!', 'danger', 0);
                        }
                    });
                }
            }
        })
    });


    $('.loadModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var action = button.data('action')
        var url    = button.data('url');
        if (!url) {
            return false;
        }

        var modal = $(this)
        modal.find('.modal-title').text(action)
        $.ajax({
            type: "Get",
            url: url,
            beforeSend: function() {
                modal.find('.modal-body').html("<h4 class='text-center'>Loading...</h4>");
            },
            success: function(data) {
                modal.find('.modal-body').html(data);
                setTimeout(function () {
                    modal.find('input[type=text], input[type=number], textarea, select').filter(':enabled:visible:first').focus();
                }, 500);
            },
            error: function(xhr, status, result) {
                modal.find('.modal-body').html(result);
            }
        });

    });

    $(document).off('click', '.back_btn').on('click', '.back_btn', function(e) {
        var backBtn = $(this);
        if(backBtn.closest('.modal').length) {
            e.preventDefault();
            backBtn.closest('.modal').modal('hide');
        } else {
            window.location.href = backBtn.attr('href');
        }
    });

    $(document).off("click", ".click_table tr").on("click", ".click_table tr", function(e) {
        var url = $(this).data("href");
        if (typeof url != "undefined") {
            window.location.href = url;
        }
    });
    $(document).off("click", ".no_redirect").on("click", ".no_redirect", function(e) {
        e.stopPropagation();
    });


    // loadNotification();
    // setInterval(function (){
    //     loadNotification();
    // }, 100000);

});
