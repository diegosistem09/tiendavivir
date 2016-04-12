<?php global $base_url; ?>

<div class="vertical-tabs clearfix">
    <div class="vertical-tabs-list">
        <ul id="layerslist">    
        </ul>
        <div class="clearfix"></div>
        <a href="#" id="addLayer">Add Layer</a>
    </div>
    <div class="vertical-tabs-panes vertical-tabs-processed" id="layeroptions" style="display: none">
        <fieldset class="fieldset-wrapper" style="border: none; padding:0; margin: 0 0 10px 0">
            Title <input type="text" name="title" class="form-text layer-option"/>
            <input type="hidden" class="layer-option" name="content" value=""/>
            <div id="content-type">
                <ul>
                    <li data-type="text"><a href="#content-text">Text or HTML</a></li>
                    <li data-type="image"><a href="#content-image">Image</a></li>
                    <li data-type="video"><a href="#content-video">Video</a></li>
                </ul>
                <div id="content-text">
                    <table width="99%">
                        <tr>
                            <td width="33%">
                                <label>Styleing Captions</label><div class="tooltip"><span><em class="callout"></em>These are Styling classes created in the settings.css  You can add unlimited amount of Styles in your own css file, to style your captions at the top level already</span></div> 
                                <?php print art_revolution_select('text_style', $captionclasses, 'layer-option'); ?>
                            </td>
                            <td width="67%">
                                <textarea class="layer-option form-textarea" name="text" id="layer-text"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="content-image">
                    <table>
                        <tr>
                            <td>
                                Image <input name="image" data-uri="[name=image_uri]" class="layer-option file-imce form-text" id="imagelayer" onchange="insertImageToLayer(this.value)"/>
                                <input type="hidden" name="image_uri" class="layer-option"/>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="content-video">
					<h3>Media in Slide</h3>
                    <select name="video_type" class="form-select layer-option">
                        <option value="youtube">YouTube Video</option>
                        <option value="vimeo">Vimeo Video</option>
                        <option value="html5">HTML5 Video</option>
                    </select>
					<div class="add-videoid">
						Video ID
						<input name="video" class="layer-option form-text"/> 
						<input type="button" id="loadvideothumbnail" class="form-submit" value="Load"/>
						Width: <input name="video_width" class="form-text layer-option"/>
						Height: <input name="video_height" class="form-text layer-option"/>
					</div>
					<div class="add-html">
						<label>HTML5 Video</label>
                        <textarea class="layer-option form-textarea" name="html" id="layer-html"></textarea>
                    </div>
                    <table>
                        <tr>
                            <td width="25%">
                                <label>data-autoplay</label><div class="tooltip"><span><em class="callout"></em>Possible Values: "true" / "false" - will play the Video Directly when slider has been loaded </span></div> 
                                <select class="form-select layer-option" name="data_autoplay">
                                    <option value="">-None-</option>
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                            </td>
                            <td width="25%">
                                <label>data-nextslideatend</label><div class="tooltip"><span><em class="callout"></em>Possible Values: "true" / "false" after video come to the end position, it swaps to the next slide automatically.</span></div> 
                                <select class="form-select layer-option" name="data_nextslideatend">
                                    <option value="">-None-</option>
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                            </td>
                            <td width="25%">
                                <label>data-thumbimage</label>
                                <div class="tooltip"><span><em class="callout"></em>the full path to an image which will be shown as Thumbnail for the Video. (only if autoplay set to false, or autoplayonlyfirsttime set to true)</span></div>
                                <input type="text" class="form-text file-imce slide-option" id="data-thumbimage" name="data_thumbimage">
                            </td>
                            <td width="25%">
                                <label>data-volume</label><div class="tooltip"><span><em class="callout"></em>If value set to "mute", video will be played muted.</span></div> 
                                <select class="form-select layer-option" name="data_volume">
                                    <option value="">-None-</option>
                                    <option value="mute">mute</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>data-forcerewind</label><div class="tooltip"><span><em class="callout"></em>Every time the Slide is shown, the Video will rewind to the start.</span></div> 
								<select class="form-select layer-option" name="data_forcerewind">
                                    <option value="">-None-</option>
                                    <option value="on">On</option>
                                    <option value="off">Off</option>
                                </select>
                            </td>
                            <td>
                                <label>data-autoplayonlyfirsttime</label><div class="tooltip"><span><em class="callout"></em>Possible Values: "true" / "false" after first Autplay the video will not be played automatically  </span></div> 
                                <select class="form-select layer-option" name="data_autoplayonlyfirsttime">
                                    <option value="">-None-</option>
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                            </td>
                            <td>
                                <label>data-forcecover</label><div class="tooltip"><span><em class="callout"></em>used only at HTML5 Videos. In case it is selected, the Videos will be resized to cover the full Slider size.</span></div>
                                <input name="data_forcecover" class="layer-option form-text"/>
                            </td>
							<td>
                                <label>data-aspectratio</label><div class="tooltip"><span><em class="callout"></em>Value example 16:9</span></div>
                                <input name="data_aspectratio" class="layer-option form-text"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <input name="width" type="hidden" class="form-text layer-option">
            <input name="height" type="hidden" class="form-text layer-option">

            <h3>Caption data- settings</h3>
            <table>
                <tr>
                    <td width="25%">
                        <label>Custom class</label><div class="tooltip"><span><em class="callout"></em>Add custom class</span></div> 
                        <input name="custom_class" class="form-text layer-option"/>
                    </td>
                    <td width="25%">
                        <label>data-x</label><div class="tooltip"><span><em class="callout"></em>Possible Values are "left", "center", "right", or any Value between -2500  and 2500.
                                If left/center/right is set, the caption will be siple aligned to the position.  Any other "number" will simple set the left position in px of tha caption. 

                                At "left" the left side of the caption is aligned to the left side of the slider.
                                At "center" the center of caption is aligned to the center of slide.  
                                At "right" the caption right side is aligned to the right side of the Slider.</span></div> 
                        <input name="left" class="form-text layer-option">
                    </td>
                    <td width="25%">
                        <label>data-y</label><div class="tooltip"><span><em class="callout"></em>Possible Values are "top", "center", "bottom", or any Value between -2500  and 2500. 
                                If top/center/bottom is set, the caption will be siple aligned to the position.  Any other "number" will simple set the top position in px of tha caption.

                                At "top" the top side of the caption is aligned to the top side of the slider.
                                At "center" the center of caption is aligned to the center of slide.  
                                At "bottom" the caption bottom side is aligned to the bottom side of the Slider.</span></div>  
                        <input name="top" class="form-text layer-option">
                    </td>
                    <td width="25%">
                        <label>Link</label><div class="tooltip"><span><em class="callout"></em>A link on the whole slide pic</span></div> 
                        <input name="link" class="form-text layer-option">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>data-hoffset</label><div class="tooltip"><span><em class="callout"></em>Only works if data-x set to left/center/right. It will move the Caption with the defined "px" from the aligned position.  i.e.  data-x="center" data-hoffset="-100" will put the caption 100px left from the slide center  horizontaly.  </span></div> 
                        <input name="data_hoffset" class="form-text layer-option">
                    </td>
                    <td>
                        <label>data-voffset</label><div class="tooltip"><span><em class="callout"></em>Only works if data-y set to top/center/bottom. It will move the Caption with the defined "px" from the aligned position.  i.e.  data-x="center" data-hoffset="-100" will put the caption 100px left from the slide center  vertically.  </span></div> 
                        <input name="data_voffset" class="form-text layer-option">
                    </td>
                    <td>
                        <label>data-captionhidden</label>
                        <select class="form-select layer-option" name="data_captionhidden">
                            <option value="">-None-</option>
                            <option value="on">On</option>
                            <option value="off">Off</option>
                        </select>
                    </td>
                    <td>
                        <label>data-start</label><div class="tooltip"><span><em class="callout"></em>The timepoint in millisecond when/at the Caption should move in to the slide.</span></div>
                        <input name="data_start" class="layer-option form-text"/>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Incoming Effect</label><div class="tooltip"><span><em class="callout"></em>How the Caption is Transformed before animation starts. All value will be animated to 0 or 1 to remove all transoformation of the Caption.</span></div>
                        <?php print art_revolution_select('incomingclasses', $incomingclasse, 'layer-option'); ?>
                    </td>
                    <td colspan="3">
                        <label>Custom Incoming Effect</label><div class="tooltip"><span><em class="callout"></em>Custom Animation (in and out) Parameters set via data-customin and data-customout within the caption div. Parameter should be closed with ";"

                                rotationX:0;rotationY:0;rotationZ:0 - value between -920 and +920. Rotation Direction set via X,Y,Z, Can be mixed
                                scaleX:1;scaleY:1 - value between 0.00 - 10.00 Scale width and height. 1 == 100%
                                skewX:1;skewY:1 - value between 0.00 - 10.00 Skew inVertical and/or horizontal direction 0 = no skew
                                opacity:1 - value between 0.00 - 1.00 Transparencity
                                transformOrigin:center center - Sets the origin around which all transforms occur. By default, it is in the center of the element ("50% 50%"). You can define the values using the keywords "top", "left", "right", or "bottom" or you can use percentages (bottom right corner would be "100% 100%") or pixels.
                                Values:left top / left center / left bottom / center top / center center / center bottom / right top / right center / right bottom or x% y%
                                transformPerspective:300 - To get your elements to have a true 3D visual perspective applied, you must either set the “perspective” property of the parent element or set the special “transformPerspective” of the element itself (common values range from around 200 to 1000, the lower the number the stronger the perspective distortion).
                                x:0;y:0; - the x / y distance of the element in px. i.e. x:-50px means vertical left 50px </span></div>
                        <input type="text" class="layer-option form-text" name="customin" style="width:99%;max-width:99%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Outgoing Effect</label><div class="tooltip"><span><em class="callout"></em>The End Transformed Style after the animation finnished. All value will be animated from 0 or 1 to the selected transformation.</span></div>
                        <?php print art_revolution_select('outgoingclasses', $outgoingclasses, 'layer-option'); ?>
                    </td>
                    <td colspan="3">
                        <label>Custom Outgoing Effect</label><div class="tooltip"><span><em class="callout"></em>Custom Animation (in and out) Parameters set via data-customin and data-customout within the caption div. Parameter should be closed with ";"

                                rotationX:0;rotationY:0;rotationZ:0 - value between -920 and +920. Rotation Direction set via X,Y,Z, Can be mixed
                                scaleX:1;scaleY:1 - value between 0.00 - 10.00 Scale width and height. 1 == 100%
                                skewX:1;skewY:1 - value between 0.00 - 10.00 Skew inVertical and/or horizontal direction 0 = no skew
                                opacity:1 - value between 0.00 - 1.00 Transparencity
                                transformOrigin:center center - Sets the origin around which all transforms occur. By default, it is in the center of the element ("50% 50%"). You can define the values using the keywords "top", "left", "right", or "bottom" or you can use percentages (bottom right corner would be "100% 100%") or pixels.
                                Values:left top / left center / left bottom / center top / center center / center bottom / right top / right center / right bottom or x% y%
                                transformPerspective:300 - To get your elements to have a true 3D visual perspective applied, you must either set the “perspective” property of the parent element or set the special “transformPerspective” of the element itself (common values range from around 200 to 1000, the lower the number the stronger the perspective distortion).
                                x:0;y:0; - the x / y distance of the element in px. i.e. x:-50px means vertical left 50px </span></div>
                        <input type="text" class="layer-option form-text" name="customout" style="width:99%;max-width:99%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>data-speed</label><div class="tooltip"><span><em class="callout"></em>The speed in milliseconds of the transition to move the Caption in the Slide at the defined  timepoint.</span></div>
                        <input name="data_speed" class="layer-option form-text"/>
                    </td>
                    <td>
                        <label>data-endspeed</label><div class="tooltip"><span><em class="callout"></em>The speed in milliseconds of the transition to move the Caption out from the Slide at the defined  timepoint.</span></div>
                        <input name="data_endspeed" class="layer-option form-text"/>
                    </td>
                    <td>
                        <label>data-easing</label><div class="tooltip"><span><em class="callout"></em>The Easing Art how the caption is moved in to the slide (note! Animation art set via Classes !).</span></div>
                        <?php print art_revolution_select('data_easing', $dataeasing, 'layer-option'); ?>
                    </td>
                    <td>
                        <label>data-endeasing</label><div class="tooltip"><span><em class="callout"></em>The Easing Art how the caption is moved out from the slide (note! Animation art set via Classes !). </span></div>
                        <?php print art_revolution_select('data_endeasing', $dataendeasing, 'layer-option'); ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>data-elementdelay</label><div class="tooltip"><span><em class="callout"></em>A Value between 0 and 1 like 0.1 to make delays between the Splitted Text Element (start) Animations. Higher the amount of words or chars, you should decrease that number!</span></div>
                        <input name="data_elementdelay" class="layer-option form-text"/>
                    </td>
					<td>
                        <label>data-endelementdelay</label><div class="tooltip"><span><em class="callout"></em>A Value between 0 and 1 like 0.1 to make delays between the Splitted Text Element (end) Animations. Higher the amount of words or chars, you should decrease that number!</span></div>
                        <input name="data_endelementdelay" class="layer-option form-text"/>
                    </td>
                    <td>
                        <label>data-splitin</label><div class="tooltip"><span><em class="callout"></em>Split Text Animation (incoming transition) to "words", "chars" or "lines". This will create amazing Animation Effects on one go, without the needs to create more captions.</span></div>
                        <select class="form-select layer-option" name="data_splitin">
                            <option value="">-None-</option>
                            <option value="words">words</option>
                            <option value="chars">chars</option>
                            <option value="lines">lines</option>
                        </select>
                    </td>
                    <td>
                        <label>data-splitout</label><div class="tooltip"><span><em class="callout"></em>Split Text Animation (outgoing transition) to "words", "chars" or "lines". Only available if data-end is set !</span></div>
                        <select class="form-select layer-option" name="data_splitout">
                            <option value="">-None-</option>
                            <option value="words">words</option>
                            <option value="chars">chars</option>
                            <option value="lines">lines</option>
                        </select>
                    </td>
                </tr>

                <tr>
					<td>
                        <label>data-end</label><div class="tooltip"><span><em class="callout"></em>The timepoint in millisecond when/at the Caption should move out from the slide.</span></div>
                        <input name="data_end" class="layer-option form-text"/>
                    </td>
                    <td colspan="3">
                        <label>Custom CSS</label><div class="tooltip"><span><em class="callout"></em>Add custom CSS for this layer.</span></div>
                        <textarea name="custom_css" class="form-textarea layer-option"></textarea>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    <div style="clear: both;"></div>
</div>