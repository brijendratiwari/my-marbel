<!-- Page Content -->
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <!--user info page-->
            <div class="user-info">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 user-details">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <?php if (empty($user_info['user_profile_pic'])) { ?>
                                    <img alt="140x140" class="img-circle img-responsive" data-src="holder.js/140x140" style="width: 140px; float: left;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                <?php } else { ?>
                                    <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 140px; height: 140px; float: left;" src="<?php echo base_url('assets/profile-imgs/' . $user_info['user_profile_pic'] . ''); ?>" data-holder-rendered="true">
                                <?php } ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 full-width768-980">
                                <h1>Nidhi Barve</h1>
                                <p><b>Marbel One Pro</b> w/ firmware 1.9.4
                                    Odometer: 210.3 miles
                                    # of recent rides: 30</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 full-width768-980">
                                <div class="round-box first">
                                    214.7
                                    <small>miles</small>
                                </div>
                                <div class="round-box">
                                    13.5
                                    <small>hours</small>
                                </div>
                                <div class="round-box last">
                                    82%
                                    <small>e-score</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='clearfix'></div>

                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Orders <span class="blue pull-right small-btn">+ order</span></div>
                        <div class="panel-body">

                            <table width="100%" class="profile-tbl">
                                <tr>
                                    <td><span class="blue">#1015662261</span></td>
                                    <td>Sep 16, 2014</td>
                                    <td>Marbel Board</td>
                                    <td>Electric Blue</td>
                                    <td>76</td>
                                    <td>Website</td>
                                    <td align="center">Shipped</td>
                                    <td align="right">$1299.00</td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Service Records <span class="blue pull-right small-btn">+ service</span></div>
                        <div class="panel-body">

                            <table width="100%" class="profile-tbl">
                                <tr>
                                    <td><span class="blue">#298</span></td>
                                    <td align="center"><i>On Hold: July 20, 2016</i></td>
                                    <td>by: Zane</td>
                                    <td>“blank”</td>
                                    <td align="center">Warranty</td>
                                    <td align="center"><span class="blue">“blank”</span></td>
                                </tr>
                                <tr>
                                    <td><span class="blue">#155</span></td>
                                    <td align="center"><i>Finished: April 6, 2016</i></td>
                                    <td>by: Zane</td>
                                    <td>“blank”</td>
                                    <td align="center">Warranty</td>
                                    <td align="center"><span class="blue">1ZX1F6859098913179</span></td>
                                </tr>
                                <tr>
                                    <td><span class="blue">#91</span></td>
                                    <td align="center"><i>Finished: March 7, 2016</i></td>
                                    <td>by: Zane</td>
                                    <td>Battery Sytem Replaced</td>
                                    <td align="center">Warranty</td>
                                    <td align="center"><span class="blue">1ZX1F6859094411870</span></td>
                                </tr>
                                <tr>
                                    <td><span class="blue">#4</span></td>
                                    <td align="center"><i>Finished: Feb 9, 2016</i></td>
                                    <td>by: Zane</td>
                                    <td>“blank”</td>
                                    <td align="center">Warranty</td>
                                    <td align="center"><span class="blue">“blank”</span></td>
                                </tr>
                            </table>

                        </div>
                    </div>



                    <div class="panel panel-default">
                        <div class="panel-heading">Tasks <span class="blue pull-right small-btn">+task regarding Nidhi</span></div>
                        <div class="panel-body">
                            <table width="100%" class="profile-tbl">
                                <tr>
                                    <td><span class="blue">Matt :</span><span> Finish/Fit</span></td>
                                    <td align="center">Order Wet Sanding Con...</td>
                                    <td align="center">In Progress</td>
                                    <td align="right">Due: 7/17/16</td>
                                </tr>
                            </table> 
                        </div>
                    </div>

                    <div class="panel shadow-none">
                        <div class="panel-heading">Timeline</div>
                        <div class="notes">
                            <textarea name="" placeholder="Leave a note..."></textarea>
                            <div class="actions">
                                <a href="#"><img src="http://mymarbel.com//assets/img/smily.png" alt="" /></a>
                                <a href="#"><img src="http://mymarbel.com//assets/img/@.png" alt="" /></a>
                                <a href="#"><img src="http://mymarbel.com//assets/img/tag.png" alt="" /></a>
                                <a href="#"><img src="http://mymarbel.com//assets/img/attach.png" alt="" /></a>
                                <button class="btn btn-default">POST</button></div>
                        </div>
                        <p class="notes-msg"><span class="pull-right">Only you and other staff members can see notes</span></p>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <ul class="comment-list">
                                <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p>Matt Belcher created a <span class="blue">Task</span> regarding  Nidhi:  Order Wet Sanding Console</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                    </div>
                                </li>

                                <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p>Service Record <span class="blue">#155</span> Finished.</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                    </div>
                                </li>

                                <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p>Service Record <span class="blue">#155</span> Finished.</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                    </div>
                                </li>

                                <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p>Service Record <span class="blue">#155</span> Finished.</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                    </div>
                                    <div class="reply-comment-box">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it. <a href="#" class="r-readmore">READ MORE</a> </p>
                                        <p class="text-center comment-count"><span style="color:#ddd">1 comment</span></p>

                                        <div class="reply-to-reply">
                                            <ul>
                                                <li>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 border-left">
                                                        <p><small>you commented</small></p>
                                                        <p>Lorem Ipsum is simply dummy text. 
                                                            <br><br>
                                                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12 pull-right">
                                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <p>Service Record <span class="blue">#155</span> Finished.</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="text-right date-posted">July 16, 2016 at 7:54 pm</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <a data-target="#resetPasswordModal" data-toggle="modal" class="btn btn-custom btn-lg">Reset Password</a>
                </div>
                <div class="col-md-4 right-info-section">

                    <div class="panel panel-default">
                        <div class="panel-heading">Details <span class="blue pull-right small-btn">edit</span></div>
                        <div class="panel-body">
                            <p>
                                <span class="blue">euphoriatek2010@gmail.com</span><br>
                                <span class="blue">euphoriatek2010@gmail.com</span><br>
                                1-317-213-0221<br><br>

                                4650 Eagle Falls Place<br>
                                Unit 1B<br>
                                Tampa, FL 33619<br>
                                United States<br><br>

                                Company: Ignis IT Solutions Pvt.Ltd.<br><br>

                            <div style="font-style:italic">  AKA: <span class="blue">Ignis</span><br>
                                Twitter: <span class="blue">@Ignis</span><br>
                                Instagram: <span class="blue">Ignis_IT</span><br>
                                LinkedIn: <span class="blue">Nidhi Bavre</span><br>
                                Reddit: <span class="blue">NidhiBavre</span><br>
                                Other: SnapChat <span class="blue">@IgnisNT</span><br><br>
                            </div>

                            Last Login:  Jul 21, 2016 at 8::56pm<br>
                            # of Recent Logins:  8
                            </p>

                            <div class="panel-heading" style="border-bottom:solid 1px #ddd;margin: 15px 0;padding:0">Comments</div>
                            <p>Nidhi is our rockstar developer helping with MyMarbel and the App. She works with Dheerendra and is about 9 hours ahead of us. She has a weekly limit of 60hrs on Upwork. </p>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">Ride Settings</div>
                        <div class="panel-body rides">
                            <p><b>Units: </b> <span class="btn btn-primary btn-blue btn-xs">empty</span></p>
                            <p><b>Notifications Rides: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                            <p><b>Safety Brake: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                            <p><b>Reverse Turned: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                            <p><b>Lock: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                            <p><b>Privacy Settings: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                            <p><b>Range Alarm: </b> <span class="btn btn-primary btn-blue btn-xs">10%</span></p>
                            <p><b>Primary Riding Style: </b> <span class="btn btn-primary btn-blue btn-xs">Commute To Work</span></p>
                            <p><b>Preffered Breaking Force: </b> <span class="btn btn-primary btn-blue btn-xs">100%</span></p>
                            <p><b>Terrain: </b> <span class="btn btn-primary btn-blue btn-xs">Flat</span></p>
                            <p><b>Parental Lock: </b> <span class="btn btn-primary btn-blue btn-xs">on</span></p>
                        </div>
                    </div>
                </div>

            </div>
            <!--/.user info page-->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->


<!--user modal ..-->


