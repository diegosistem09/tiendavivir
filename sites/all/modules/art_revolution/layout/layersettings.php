<?php global $theme_root; ?>
<input type="hidden" name="sid" value="<?php print arg(2); ?>"/>
<div id="art_revolution">
    <div id="slidesdesign">
        <div id="slidedesign" style="margin:0 auto;width:960px; height: 400px; border: 1px solid #ccc; list-style: none;position: relative;">

        </div>
        <div id="preview" style="margin: 0 auto; display: none">
            <iframe style="overflow: hidden" src="" width="99%" height="99%" frameboder="0"></iframe>
        </div>

        <div class="main-slideslist">
            <ul id="slideslist" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix "></ul>
            <a href="#" id="addslide">Add Slide</a>
        </div>

        <div class="clearfix"></div>

        <div id="art_revolution_main">
            <fieldset id="slide-options" class="form-wrapper">
                <legend><span class="fieldset-legend"><div class="minus"></div><h3 class="options_heading">Slide options</h3></span></legend>
                <div class="fieldset-wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <td width="25%">
                                    <label>Slide title</label> <input name="title" class="slide-option form-text"/>
                                </td>
                                <td width="25%">
                                    <label>data-link</label> 
                                    <div class="tooltip"><span><em class="callout"></em>A link on the whole slide pic</span></div>
                                    <input type="text" name="data_link" class="form-text slide-option">
                                </td>
                                <td width="25%">
                                    <label>data-target</label> 
                                    <div class="tooltip"><span><em class="callout"></em>The target of the Link for the whole slide pic. (i.e. "_blank", "_self")</span></div>
                                    <?php print art_revolution_select('data_target', $linktaget, 'slide-option'); ?>
                                </td>
                                <td width="25%">
                                    <label>data-slideindex</label>
                                    <div class="tooltip"><span><em class="callout"></em>Possible values:  next,back, 1-x (where x is the max. Amount of slide) If this value is set, click on slide will call the next / previous, or  n th Slide.</span></div>
                                    <input type="text" class="form-text slide-option" name="data_slideindex">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Background image</label> 
                                    <input name="background_image" id="background-image" data-uri="[name=background_image_uri]" class="file-imce form-text slide-option" onchange="setSlideSackground(this.value)"/>
                                    <input type="hidden" name="background_image_uri" class="slide-option"/>
                                </td>
                                <td>
                                    <label>Thumbnail</label>
                                    <div class="tooltip"><span><em class="callout"></em>An Alternative Source for thumbs. If not defined a copy of the background image will be used in resized form</span></div>
                                    <input type="text" class="form-text file-imce slide-option" id="data-thumb" name="data_thumb">
                                </td>
                                <td colspan="2">
									<label>Custom Attribute for Background</label> 
                                    <div class="tooltip"><span><em class="callout"></em>Enter Custom Attribute for Background</span></div>
                                    <input type="text" name="custom_attribute_bg" class="form-text slide-option">
								</td>
                            </tr>
                            <tr>
                                <td width="25%">
                                    <label>data-transition</label> 
                                    <div class="tooltip"><span><em class="callout"></em>The appearance transition of this slide. You can define more than one, so in each loop the next slide transition type will be shown.</span></div>
                                    <?php print art_revolution_select('data_transition', $datatransition, 'slide-option'); ?>
                                </td>       
                                <td width="25%">
                                    <label>data-slotamount</label> 
                                    <div class="tooltip"><span><em class="callout"></em>The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy.</span></div>
                                    <input type="text" name="data_slotamount" class="form-text slide-option">
                                </td>
                                <td width="25%">
                                    <label>data-masterspeed</label> 
                                    <div class="tooltip"><span><em class="callout"></em>The speed of the transition in "ms".  default value is 300 (0.3 sec)</span></div>
                                    <input type="text" name="data_masterspeed" class="form-text slide-option">
                                </td>
                                <td width="25%">
                                    <label>data-delay</label> 
                                    <div class="tooltip"><span><em class="callout"></em>A new Dealy value for the Slide. If no delay defined per slide, the dealy defined via Options will be used</span></div>
                                    <input type="text" name="data_delay" class="form-text slide-option">
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </fieldset>
            <fieldset id="layer-options" class="form-wrapper">
                <legend><span class="fieldset-legend"><div class="plus"></div><h3 class="options_heading">Layer options</h3></span></legend>
                <div class="fieldset-wrapper">
                    <div>
                        <?php include 'slidesettings.php'; ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<div>
    <input type="button" id="save" class="form-submit" value="Save"/>
    <input type="button" id="save2" class="form-submit" value="Save & Continue"/>
</div>
<?php global $base_url; ?>
<script type="text/javascript">
                                        var filehandle = null;
                                        jQuery(document).ready(function($) {
                                            $('#art_revolution').tabs({
                                                selected: 1,
                                                active: 1,
                                                select: function(event, ui) {
                                                    $('#slidedesign, #preview').width($settings.startwidth).height($settings.startheight);
                                                    if ($('#slidedesign').width() > $('#art_revolution').width()) {
                                                        var $scale = $('#art_revolution').width() / $('#slidedesign').width();
                                                    }
                                                },
                                                activate: function(event, ui) {
                                                    $('#slidedesign, #preview').width($settings.startwidth).height($settings.startheight);
                                                    if ($('#slidedesign').width() > $('#art_revolution').width()) {
                                                        var $scale = $('#art_revolution').width() / $('#slidedesign').width();
                                                    }
                                                }
                                            });
                                            $('.file-imce').click(function() {
                                                filehandle = $(this);
                                                Drupal.media.popups.mediaBrowser(function(files) {
                                                    var image = files[0];
                                                    filehandle.val(image.url).trigger('onchange');
                                                    $(filehandle.data('uri')).val(image.uri);
                                                });
                                            })
                                        })
                                        function send(fid) {
                                            alert(fid);
                                        }
                                        function art_revolution_fileselect(file, win) {
                                            filehandle.val(file.url);//insert file url into the url field
                                            filehandle.trigger('onchange');
                                            win.close();//close IMCE
                                        }
                                        function insertImageToLayer(url) {
                                            var layerid = $currentSlide + '-' + $currentLayer;
                                            var img = jQuery('<img>').attr('src', url);
                                            jQuery('#' + layerid).find('.inner').html(img);
                                            var image = new Image();
                                            image.onload = function() {
                                                jQuery('#' + layerid).width(this.width);
                                                jQuery('#' + layerid).height(this.height);
                                                jQuery('input[name=width]').val(this.width);
                                                jQuery('input[name=height]').val(this.height);
                                            }
                                            image.src = url;
                                        }
                                        function setSlideSackground(url) {
                                            jQuery('#slidedesign').css({
                                                backgroundImage: 'url(' + url + ')'
                                            });
                                        }

                                        jQuery("#slide-options .fieldset-wrapper").show();
                                        jQuery("#slide-options .fieldset-legend").click(function() {
                                            jQuery("#slide-options .fieldset-wrapper").slideToggle("slow");
                                            jQuery(this).toggleClass("active");
                                            jQuery('#slide-options .minus').toggleClass('plus hide');
                                        });

                                        jQuery("#layer-options .fieldset-wrapper").hide();
                                        jQuery("#layer-options .fieldset-legend").click(function() {
                                            jQuery("#layer-options .fieldset-wrapper").slideToggle("slow");
                                            jQuery(this).toggleClass("active");
                                            jQuery('#layer-options .plus').toggleClass('minus');
                                        });
</script>