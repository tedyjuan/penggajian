<div class="x_panel">
    <div class="x_title">
        <h2>Form <?php echo $title ?><small></small></h2>      
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />

        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nik">NIK<span class="err_nik required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nik" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nik'])) ? $default['nik'] : ''; ?>"
                           <?php echo (isset($default['readonly_nik'])) ? $default['readonly_nik'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama<span class="err_nama required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nama" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nama'])) ? $default['nama'] : ''; ?>"
                           <?php echo (isset($default['readonly_nama'])) ? $default['readonly_nama'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_ktp">NO KTP<span class="err_no_ktp required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" maxlength='16' id="no_ktp" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['no_ktp'])) ? $default['no_ktp'] : ''; ?>"
                           <?php echo (isset($default['readonly_no_ktp'])) ? $default['readonly_no_ktp'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_npwp">NO NPWP<span class="err_no_npwp required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" maxlength='16' id="no_npwp" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['no_npwp'])) ? $default['no_npwp'] : ''; ?>"
                           <?php echo (isset($default['readonly_no_npwp'])) ? $default['readonly_no_npwp'] : ''; ?>      
                           >
                </div>
            </div>
            <!-- START -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_bagian">Bagian<span class="err_id_bagian required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_bagian" name="id_bagian" >
                        <?php foreach ($default['id_bagian'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <!-- START -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_jabatan">Jabatan<span class="err_nama_jabatan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_jabatan" name="id_jabatan" >
                        <?php foreach ($default['id_jabatan'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jeniskelamin">Jenis Kelamin<span class="err_jeniskelamin required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="jeniskelamin" name="jeniskelamin" >
                        <?php foreach ($default['jeniskelamin'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tempat_lahir">Tempat lahir<span class="err_tempat_lahir required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tempat_lahir" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['tempat_lahir'])) ? $default['tempat_lahir'] : ''; ?>"
                           <?php echo (isset($default['readonly_tempat_lahir'])) ? $default['readonly_tempat_lahir'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_status">Status Nikah<span class="err_id_status required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_status" name="id_status" >
                        <?php foreach ($default['id_status'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_lahir">Tanggal Lahir<span class="err_tgl_lahir required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="tgl_lahir" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['tgl_lahir'])) ? $default['tgl_lahir'] : ''; ?>"
                           <?php echo (isset($default['readonly_tgl_lahir'])) ? $default['readonly_tgl_lahir'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_agama">Agama<span class="err_nama_agama required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_agama" name="id_agama" >
                        <?php foreach ($default['id_agama'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat<span class="err_alamat required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="alamat" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['alamat'])) ? $default['alamat'] : ''; ?>"
                           <?php echo (isset($default['readonly_alamat'])) ? $default['readonly_alamat'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telepon">Telepon<span class="err_telepon required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" maxlength='13' id="telepon" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['telepon'])) ? $default['telepon'] : ''; ?>"
                           <?php echo (isset($default['readonly_telepon'])) ? $default['readonly_telepon'] : ''; ?>      
                           >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_pendidikan">Pendidikan Terakhir<span class="err_nama_pendidikan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="id_pendidikan" name="id_pendidikan" >
                        <?php foreach ($default['id_pendidikan'] as $row) { ?>

                            <option value="<?php echo (isset($row['value'])) ? $row['value'] : ''; ?>" 
                                    <?php echo (isset($row['selected'])) ? $row['selected'] : ''; ?> >
                                <?php echo (isset($row['display'])) ? $row['display'] : ''; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_institusipendidikan">Nama Institusi Pendidikan<span class="err_nama_institusipendidikan required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="nama_institusipendidikan" required="required" class="form-control col-md-7 col-xs-12"
                           value="<?php echo (isset($default['nama_institusipendidikan'])) ? $default['nama_institusipendidikan'] : ''; ?>"
                           <?php echo (isset($default['readonly_nama_institusipendidikan'])) ? $default['readonly_nama_institusipendidikan'] : ''; ?>      
                           >
                </div>
            </div>





            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="reset" id="cancel" class="btn btn-primary">Cancel</button>
                    <button type="submit" id ="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        var buttonsave, buttoncancel, urlpost, urlindex, content;

        buttonsave = $('#submit');
        buttoncancel = $('#cancel');
        urlpost = '<?php echo $url_post; ?>';
        urlindex = '<?php echo $url_index; ?>';
        content = $("#contentdata");

        $("#tgl_lahir").datepicker();

        buttonsave.click(
                function ()
                {

                    $.ajax(
                            {
                                type: "POST",
                                url: urlpost,
                                dataType: "json",
                                data: {
                                    id: $("#id").val(),
                                    nik: $("#nik").val(),
                                    nama: $("#nama").val(),
                                    jeniskelamin: $("#jeniskelamin").val(),
                                    no_ktp: $("#no_ktp").val(),
                                    no_npwp: $("#no_npwp").val(),
                                    id_jabatan: $("#id_jabatan").val(),
                                    tempat_lahir: $("#tempat_lahir").val(),
                                    id_status: $("#id_status").val(),
                                    tgl_lahir: $("#tgl_lahir").val(),
                                    id_agama: $("#id_agama").val(),
                                    id_bagian: $("#id_bagian").val(),
                                    alamat: $("#alamat").val(),
                                    telepon: $("#telepon").val(),
                                    id_pendidikan: $("#id_pendidikan").val(),
                                    nama_institusipendidikan: $("#nama_institusipendidikan").val(),
                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {
                                            if (data.hasil == 'true') {
                                                load_form(urlindex);
                                            } else {
                                                $(".err_nik").html(data.err_nik).fadeIn('slow');
                                                $(".err_nama").html(data.err_nama).fadeIn('slow');
                                                $(".err_jeniskelamin").html(data.err_jeniskelamin).fadeIn('slow');
                                                $(".err_no_ktp").html(data.err_no_ktp).fadeIn('slow');
                                                $(".err_nama_jabatan").html(data.err_nama_jabatan).fadeIn('slow');
                                                $(".err_tempat_lahir").html(data.err_tempat_lahir).fadeIn('slow');
                                                $(".err_tgl_lahir").html(data.err_tgl_lahir).fadeIn('slow');
                                                $(".err_id_status").html(data.err_id_status).fadeIn('slow');
                                                $(".err_nama_agama").html(data.err_nama_agama).fadeIn('slow');
                                                $(".err_alamat").html(data.err_alamat).fadeIn('slow');
                                                $(".err_telepon").html(data.err_telepon).fadeIn('slow');
                                                $(".err_bagian").html(data.err_bagian).fadeIn('slow');
                                                $(".err_nama_pendidikan").html(data.err_nama_pendidikan).fadeIn('slow');
                                                $(".err_nama_institusipendidikan").html(data.err_nama_institusipendidikan).fadeIn('slow');

                                            }
                                        },
                                error: function (request, status, error) {
                                    alert(request.responseText + " " + status + " " + error);
                                }
                            });
                    return false;

                });

        buttoncancel.click(
                function ()
                {
                    load_form(urlindex);
                });




    });

</script>