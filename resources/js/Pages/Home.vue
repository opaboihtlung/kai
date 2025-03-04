
<template>
    <q-page class="container" padding>
        <div class="hero-section row q-col-gutter-sm q-mt-md relative-position">
            <div v-if="$q.screen.gt.sm" style="z-index:5;padding-right: 220px" class="absolute-center ">
                <img   src="assets/images/red-eclipse.png"/>
            </div>
            <div style="z-index: 10" class="col-xs-12 col-sm-5">
<!--                start left hero components-->
                <div class="hero-left column">
                    <br/>
                    <div style="max-width: 430px" class="hero-cpm relative-position">
                        <div>
                            <q-img  src="/assets/images/qr-icon.png" width="35px"/>
                            <div class="home-title q-mt-sm hero-title">
                                Attendance Management App
                            </div>
                            <div class="text-dark q-mt-sm">A one-of-a-kind attendance application designed for managing the attendance of government employees in Mizoram.</div>
                        </div>
                    </div>

                    <div  class="q-pl-md q-my-lg">
                        <div class="home-title opaque">Download app</div>
                        <div class="q-mt-xs flex  items-center  q-gutter-md">
                            <DownloadButton :img="'/assets/images/android-icon.svg'"
                                            link="https://play.google.com/store/apps/details?id=com.msegs.kai"
                                            class="bg-white"
                                            :title="'Playstore'"
                                            :caption="'Get it on'"/>

                            <DownloadButton :img="'/assets/images/apple-icon.svg'"
                                            link="https://apps.apple.com/in/app/kai-attendance/id6478542853"
                                            :title="'AppStore'"
                                            :caption="'Download on the'"/>
                        </div>
                    </div>
                    <div class="q-pl-md q-my-lg">
                        <div class="home-title opaque">Go to dashboard</div>
                        <br>
                        <a :href="route('homedashboard')">
  <q-img src="/assets/images/homedashboard.png" width="400px" />
</a>
                    </div>

                </div>
            </div>
<!--           end left hero component-->
            <div style="z-index: 10" class="col-xs-12 col-sm-7">
                <div class="hero-right column items-center">
                    <div class="component-2 flex q-gutter-md justify-center items-center ">
                            <div class="item-cpm2">
                                <div>
                                    <img src="assets/images/scan.png" width="20px" class="q-pt-xs q-mr-sm"/>
                                </div>
                                <div>
                                    <div class="title-cmp2">Hassle free</div>
                                    <div class="caption-cmp2">For users, scan with ease from your mobile.</div>
                                </div>
                            </div>

                            <div class="item-cpm2">
                                <div>
                                    <img src="assets/images/scan.png" width="20px" class="q-pt-xs q-mr-sm"/>
                                </div>
                                <div>
                                    <div class="title-cmp2">Easy to manage</div>
                                    <div class="caption-cmp2 wrap">Admin can easily manage user’s information at the click of a button.</div>
                                </div>
                            </div>

                    </div>


                    <div class="component-3 full-width flex q-gutter-sm items-center justify-center">
                        <div class="title-cpm3">Discover New Ways to Manage Attendance</div>
                        <img src="assets/images/qr-right.png" width="120px" class="q-mt-xl"/>
                        <img src="assets/images/kai-app.png"/>
                    </div>
                </div>

            </div>
        </div>
        <br/>
        <br/>
        <br/>
        <div id="userguide" class="userguide">
    <div class="flex justify-center items-center">
        <div class="text-center">
            <div class="feature-title">User Guide</div>
            <div class="home-line2"></div>
        </div>
    </div>
</div>

<div class="content-wrapper q-pl-md q-my-lg">
    <div class="video-section">
        <div class="home-title opaque">Video</div>
        <div class="q-mt-xs flex items-center q-gutter-md">
            <iframe width="620" height="400" src="https://www.youtube.com/embed/tCjfV7uqbzE" title="KAI - GoM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
    <div class="download-section q-pl-md q-my-lg">
        <div class="home-title opaque">Download User Manual</div>
        <div class="q-mt-xs flex items-center q-gutter-md">
            <DownloadButton2 :img="'/assets/images/pdf.svg'"
                            link="/storage/usermanual/UserManual_MIZO_.pdf"
                            class="bg-white"
                            :title="'Mizo Tawngin'"
                            :style="{ marginRight: '20px' }"


            />
            <DownloadButton2 :img="'/assets/images/pdf.svg'"
                link="/storage/usermanual/UserManual_ENG_.pdf"
                class="bg-white"
                :title="'In English'"
/>


        </div>
    </div>
</div>

        <div id="feature" class="feature">
            <div class="flex justify-center items-center">
                <div class="text-center">
                    <div class="feature-title">Features</div>
                    <div class="home-line"/>
                </div>

            </div>
        </div>

        <div class="flex justify-between">
            <div class="feature-child">
                <div class="feature-child-item">
                    <div>
                        <img src="assets/images/qr-icon.png" width="20px" class="q-pt-xs q-mr-sm "/>
                    </div>
                    <div>
                        <div class="feature">Attendance</div>
                        <div class="feature-caption">This allow user to punch their attendance. All records of each user can easily be shown.</div>
                    </div>
                </div>
                <div class="feature-child-item ">
                    <div>
                        <img src="assets/images/qr-icon.png" width="20px" class="q-pt-xs q-mr-sm "/>
                    </div>
                    <div>
                        <div class="feature">Manage Device</div>
                        <div class="feature-caption">User has the ability to change device (mobile) with permission of organization admin.</div>
                    </div>
                </div>
            </div>
            <div v-if="$q.screen.gt.sm" class="feature-child">
                <img src="/assets/images/dashboard.png"/>
            </div>
            <div class="feature-child">
                <div class="feature-child-item">
                    <div>
                        <img src="assets/images/users.png" width="20px" class="q-pt-xs q-mr-sm "/>
                    </div>
                    <div>
                        <div class="feature">Employee Management</div>
                        <div class="feature-caption">Organization administrator can management their own employee.</div>
                    </div>
                </div>
                <div class="feature-child-item">
                    <div>
                        <img src="assets/images/notification.png" width="20px" class="q-pt-xs q-mr-sm "/>
                    </div>
                    <div>
                        <div class="feature">Notification</div>
                        <div class="feature-caption">Allow users to notify information.</div>
                    </div>
                </div>
                <div class="feature-child-items">
                    <div>
                        <img src="assets/images/qr-icon.png" width="20px" class="q-pt-xs q-mr-sm "/>
                    </div>
                    <div>
                        <div class="feature">Integrated with </div>
                        <div class="feature">E-leave Mizoram</div>
                        <div class="feature-caption">To efficiently manage and maintain records of users leave statuses.</div>
                    </div>
                </div>
            </div>


        </div>

        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <div id="about" class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="about flex justify-center ">
                    <img style="margin-top: -130px" src="assets/images/kai-app-combo.png"/>
                    <div class="q-pa-md column justify-center" style="max-width: 140px">
                        <div class="about-title">About the app</div>
                        <div class="about-line"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="about-passage">
                    <p>
                        Kai, the ultimate solution for effortless attendance tracking! Say goodbye to
                        the hassle of traditional attendance systems and embrace the power of QR codes to streamline your attendance management process.
                    </p>
                    <p>
                        Kai redefines attendance tracking by incorporating location intelligence into the process.
                        Administrators can effortlessly generate QR codes paired with geofences for their office.
                        This dual-layered approach ensures accurate attendance recording based on both QR code scans and participants'
                        physical presence within designated areas.
                    </p>


                </div>
            </div>
        </div>
        <br/>
        <br/>
        <br/>
    </q-page>
</template>

<script setup>
import FrontLayout from "@/Layouts/FrontLayout.vue";
import DownloadButton from "@/Components/DownloadButton.vue";
import DownloadButton2 from "@/Components/DownloadButton2.vue";
import { router } from "@inertiajs/vue3";


defineOptions({
    layout:FrontLayout
})
</script>
<style scoped>
.content-wrapper {
    display: flex;
    justify-content: space-between; /* Distribute items evenly across the container */
    align-items: flex-start; /* Align items to the top */
    flex-wrap: wrap; /* Wrap items if they exceed container width */
    margin-bottom: 20px;
    margin-right: 120px; /* Add space at the bottom of the content-wrapper */
}

.video-section {
    width: calc(57% - 10px); /* Calculate width for the video section (50% with margin) */
    margin-right: 10px; /* Add some space between sections */
    margin-bottom: 20px; /* Add space at the bottom of the video section */
}

.video-section .q-gutter-md {
    display: flex;
    align-items: center; /* Align items vertically center */
}
.hero-right{
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.app-shadow{
    box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    -webkit-box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    -moz-box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    border-radius: 16px;
    background-color: #ffffff;
    opacity: 0.5;
}
.app-shadow::before {
    content: ""; /* Create a pseudo-element */
    position: absolute; /* Position the pseudo-element absolutely */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.3; /* Apply opacity to the pseudo-element */
}
.component-3{
    box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -moz-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    margin-top: 32px;
    background: #1DEFFF;
    border-radius: 21px;
    padding: 2px 16px;
}
.component-2{
    padding: 62px 21px;
    background: #191C51;
    border-radius: 21px;
    box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -moz-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    max-width: 550px;
}
.title-cmp2{
    color: #1ED9E8;
    font-size: 20px;
    font-weight: bold;
}
.caption-cmp2{
    font-size: 14px;
    color: #7D82D3;
}
.title-cpm3{
    color: #191C51;
    font-weight: bold;
    font-size: 35px;
    max-width: 250px;
    margin-left: 26px;
}
.item-cpm2{
    flex: 0 0 230px;
    display: flex;
    margin-top: 0;
}
.hero-cpm{
    box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    -webkit-box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    -moz-box-shadow: 0px 4px 65px 34px rgba(0,0,0,0.25);
    padding: 48px 36px;
    background-color: rgba(255,255,255,0.4);
    border-radius: 20px;
}
.hero-title {
    /* This element will not inherit the parent's opacity */
    position: relative; /* Make the child element position: relative */
    z-index: 1; /* Move the child element above the pseudo-element */
}
.feature-title{

    color: #191C51;
    font-weight: bold;
    font-size: 35px;
}
.home-line{
    background-color: #1DEFFF;
    height:5px;
    width: 170px;
}
.home-line2{
    background-color: #1DEFFF;
    height:6px;
    width: 200px;
}
.feature{
    color: #1ED9E8;
    font-size: 20px;
    font-weight: bold;
}
.feature-caption{
    color: #191C51;
    font-size: 14px;
    font-weight: normal;
}
.feature-child{
    flex: 0 0 240px;
    display: flex;
    flex-direction: column;
    margin-top: 0;
}
.feature-child-item{
    flex: 0 0 130px;
    display: flex;
    margin-top: 0;
}
.feature-child-items{
    flex: 0 0 130px;
    display: flex;
    margin-top: -50px;
}
.about{
    box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -webkit-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    -moz-box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);
    background: #1DEFFF;
    border-radius: 21px;
    padding-left: 21px;
    padding-right: 21px;
}
.about-title{
    color: #191C51;
    font-size: 35px;
    font-weight: bold;
}
.about-line{
    background-color: white;
    height: 5px;
}
.about-passage{
    padding: 21px;
}
.move-left {
    margin-left: -50px; /* Adjust the value as needed */
}
</style>

