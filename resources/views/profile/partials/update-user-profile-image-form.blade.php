{{ html()->model($user)->form('POST', route('profile.avatar.upload'))->acceptsFiles()->open() }}
<div class="card">
    <div class="card-body">

        <h4 class="card-title">Update Profile Image</h4>
        <p class="card-title-desc">Update your profile image</p>

        <div class="row">
            <div class="col-md-auto">
                @include('partials.user-avatar-with-status', [
                    'partial_user' => $user,
                    'show_upload_control' => true,
                ])
            </div>
            <div class="col-md">
                <input type="file" id="profile_image" name="profile_image" required />
            </div>
        </div>

    </div>
    <div class="card-footer">
        <div class="d-grid">
            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                <i class="fas fa-save"></i> Update Profile Image
            </button>
        </div>
    </div>
</div>
{{ html()->form()->close() }}

@push('page-scripts')
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script>
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"][id="profile_image"]');

    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // Create a FilePond instance
    const pond = FilePond.create( inputElement, {
        maxFileSize: '2MB',
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxFiles: 1,
        server: {
            url: "/filepond/",
            headers: {
                'X-CSRF-TOKEN': "{{ @csrf_token() }}",
            },
            process: "process",
            revert: "revert"
        },
        labelIdle: 'Update profile image: Drag & Drop your file or <span class="filepond--label-action"> Browse </span>',
        onaddfilestart: (file) => { isLoadingCheck(); },
        onprocessfile: (files) => { isLoadingCheck(); }
    });

    function isLoadingCheck()
    {
        var isLoading = pond.getFiles().filter(x=>x.status !== 5).length !== 0;
        if(isLoading)
        {
            $('#frmAvatarUpload [type="submit"]').attr("disabled", "disabled");
        }
        else
        {
            $('#frmAvatarUpload [type="submit"]').removeAttr("disabled");
        }
    }

    function hideAll()
    {
        var panels = ["personal", "signature", "password"];
        $.each(panels, function(index, value){
            $("#"+value).addClass('d-none');
        });
    }

    function showPanel(panel_id)
    {
        hideAll();
        $(panel_id).removeClass('d-none');
    }

    $(function(){

        var url = window.location.href;
        if(url.indexOf("#") !== -1)
        {
            var panel_id = url.substr(url.indexOf("#") + 1);
            showPanel("#"+panel_id);
        }

        $("a.profilePanels").on('click', function(){
            var panel_id = $(this).attr('href');
            showPanel(panel_id);
        });

        var minimized_elements = $('p.minimize');
        var minimize_character_count = 50;

        minimized_elements.each(function(){
            var t = $(this).text();
            if(t.length < minimize_character_count ) return;

            $(this).html(
                t.slice(0,minimize_character_count )+'<span>... </span><a href="#" class="more">More</a>'+
                '<span style="display:none;">'+ t.slice(minimize_character_count ,t.length)+' <a href="#" class="less">Less</a></span>'
            );

        });

        $('a.more', minimized_elements).click(function(event){
            event.preventDefault();
            $(this).hide().prev().hide();
            $(this).next().show();
        });

        $('a.less', minimized_elements).click(function(event){
            event.preventDefault();
            $(this).parent().hide().prev().show().prev().show();
        });


    });

</script>

@endpush
