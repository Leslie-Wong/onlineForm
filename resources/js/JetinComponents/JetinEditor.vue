<template>
    <div id="app">
      <editor
        api-key=""
        :init='init'

        :initial-value="tinymceData"
        v-model="tinymceData"
      />
    </div>
  </template>

  <script>
  import tinymce from 'tinymce/tinymce.js'
  import 'tinymce/models/dom';

  import 'tinymce/skins/ui/oxide/skin.min.css';
  import 'tinymce/skins/ui/oxide/content.min.css';
  import 'tinymce/themes/silver';


  import 'tinymce/plugins/insertdatetime';
  import 'tinymce/plugins/advlist';
  import 'tinymce/plugins/lists';
  import 'tinymce/icons/default'
  import 'tinymce/plugins/wordcount';
  import 'tinymce/plugins/accordion';
  import 'tinymce/plugins/pagebreak';
  import 'tinymce/plugins/image';
  import 'tinymce/plugins/media';
  import 'tinymce/plugins/link';
  import 'tinymce/plugins/code';
  import 'tinymce/plugins/fullscreen';
  import 'tinymce/plugins/preview';
  import 'tinymce/plugins/table';
  import 'tinymce/plugins/template';



  import Editor from "@tinymce/tinymce-vue";
  import { ref, watch, watchEffect, defineComponent } from "vue";
  export default defineComponent({
    name: "JetinEditor",
    components: {
      editor: Editor,
    },
    props: {
      modelValue: {
          default: null,
      },
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
      const tinymceData = ref(props.modelValue)
      watch(
        () => tinymceData.value,
        (data) => emit('update:modelValue', data)
      )
      return {
        tinymceData,
      }
    },
    data() {
        let init = {
          content_css: false,
          skin: false,
          branding: false,
          height: 500,
          menubar: false,
          plugins: "accordion advlist lists wordcount pagebreak image media link code fullscreen preview table insertdatetime template",
          toolbar1: "blocks fontfamily fontsize bold italic underline strikethrough align forecolor backcolor  outdent indent ltr rtl numlist bullist template table accordion  undo redo  removeformat pagebreak  insertfile image media link insertdatetime  code fullscreen  preview",
          toolbar_mode: 'floating',
          mobile: {
              // plugins: "accordion advlist lists wordcount pagebreak image media link code fullscreen preview table insertdatetime template",
              // toolbar: "blocks fontfamily fontsize bold italic underline strikethrough align forecolor backcolor  outdent indent ltr rtl numlist bullist template table accordion  undo redo  removeformat pagebreak  insertfile image media link insertdatetime  code fullscreen  preview",
              toolbar_mode: 'wrap',
          },
          // images_upload_url: 'postAcceptor.php',
          // images_upload_handler: function (blobInfo, success, failure) {
          //   setTimeout(function () {
          //     /* no matter what you upload, we will turn it into TinyMCE logo :)*/
          //     success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
          //   }, 2000);
          // },

          template_mdate_format: '%m/%d/%Y : %H:%M',
          templates : [
            {
              title: 'Date modified example',
              description: 'Adds a timestamp indicating the last time the document modified.',
              content: '<p>Last Modified: <time class="mdate">This will be replaced with the date modified.</time></p>'
            },
            {
              title: 'Replace values example',
              description: 'These values will be replaced when the template is inserted into the editor content.',
              content: '<p>Name: {$username}, StaffID: {$staffid}</p>'
            },
            {
              title: 'Replace values preview example',
              description: 'These values are replaced in the preview, but not when inserted into the editor content.',
              content: '<p>Name: {$preview_username}, StaffID: {$preview_staffid}</p>'
            },
            {
              title: 'Quotation Header',
              description: 'The Header for quotation the content.',
              content: `
                          <p>&nbsp;</p>
                          <table style="border-collapse: collapse; width: 100%; border-width: 0px; border-spacing: 0px; height: 18.9091px; margin-left: auto; margin-right: auto;" border="0"><colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
                          <tbody>
                          <tr style="height: 18.9091px;">
                          <td style="border-width: 1px; padding: 0px; text-align: center; height: 18.9091px;">{$Logo}</td>
                          <td style="border-width: 1px; padding: 0px; height: 18.9091px; text-align: center;"><span lang="EN-US" style="font-size: 22.0pt; line-height: 107%; font-family: 'Arial',sans-serif; mso-fareast-font-family: 新細明體; mso-fareast-theme-font: minor-fareast; mso-ansi-language: EN-US; mso-fareast-language: ZH-TW; mso-bidi-language: AR-SA;">QUOTATION</span></td>
                          </tr>
                          </tbody>
                          </table>
                          <p>&nbsp;</p>
                          <table class="MsoTableGrid" style="border-collapse: collapse; border: none; width: 100%; border-spacing: 0px;" border="1" cellspacing="0" cellpadding="0">
                          <tbody>
                          <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 17.5pt;">
                          <td style="width: 100.218%; border: none; background: rgb(213, 220, 228); padding: 0cm 5.4pt; height: 17.5pt;" colspan="6" width="680">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="color: black; mso-color-alt: windowtext;">QUOTATION REFERENCE </span></p>
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 18.6412%; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="108">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">REFERENCE NO.</span></p>
                          </td>
                          <td style="width: 24.4558%; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="171">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$qut_code}</span></p>
                          </td>
                          <td style="width: 16.2469%; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="104">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">ISSUED DATE</span></p>
                          </td>
                          <td style="width: 12.8265%; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="98">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$issued_date}</span></span></p>
                          </td>
                          <td style="width: 15.3918%; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="103">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">VALID TILL</span></p>
                          </td>
                          <td style="width: 12.6555%; border-top: none; border-right: none; border-left: none; border-image: initial; border-bottom: 1pt solid windowtext; padding: 0cm 5.4pt; height: 11.9pt;" width="98">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$valid_till}</span></span></p>
                          </td>
                          </tr>
                          </tbody>
                          </table>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US">&nbsp;</span></p>
                          <table class="MsoTableGrid" style="border-collapse: collapse; border: none; width: 100%; border-spacing: 0px; height: 171.988px;" border="1" cellspacing="0" cellpadding="0">
                          <tbody>
                          <tr style="height: 34.3977px;">
                          <td style="width: 520.95pt; border: none; background: rgb(213, 220, 228); padding: 0cm 5.4pt; height: 34.3977px;" colspan="4" width="695">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="color: black; mso-color-alt: windowtext;">CLIENT DETAILS</span></p>
                          </td>
                          </tr>
                          <tr style="height: 34.3977px;">
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">COMPANY NAME</span></p>
                          </td>
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$company_name}</span></span></span></p>
                          </td>
                          <td style="width: 50.75pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 137.591px;" rowspan="4" valign="top" width="68">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%;">ADDRESS</span></p>
                          </td>
                          <td style="width: 209.7pt; border-top: none; border-right: none; border-left: none; border-image: initial; border-bottom: 1pt solid windowtext; padding: 0cm 5.4pt; height: 137.591px;" rowspan="4" valign="top" width="280">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$address}</span></span></span></p>
                          </td>
                          </tr>
                          <tr style="height: 34.3977px;">
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">CONTACT NAME</span></p>
                          </td>
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$contact_name}</span></span></span></p>
                          </td>
                          </tr>
                          <tr style="height: 34.3977px;">
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">PHONE / WHATSAPP</span></p>
                          </td>
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$contact_phone}</span></span></span></p>
                          </td>
                          </tr>
                          <tr style="height: 34.3977px;">
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 9.0pt; line-height: 115%;">EMAIL</span></p>
                          </td>
                          <td style="width: 130.2pt; border-top: none; border-left: none; border-bottom: 1pt solid windowtext; border-right: 1pt solid windowtext; padding: 0cm 5.4pt; height: 34.3977px;" width="174">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;<span lang="EN-US" style="font-size: 9.0pt; line-height: 115%; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin;">{$contact_email}</span></span></span></p>
                          </td>
                          </tr>
                          </tbody>
                          </table>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US">&nbsp;</span></p>
                          <table class="MsoTableGrid" style="width: 100%; border-collapse: collapse; border: none; border-spacing: 0px;" border="1" width="683" cellspacing="0" cellpadding="0">
                          <tbody>
                          <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 17.95pt;">
                          <td style="width: 511.9pt; border: none; background: #D5DCE4; mso-background-themecolor: text2; mso-background-themetint: 51; padding: 0cm 5.4pt 0cm 5.4pt; height: 17.95pt;" colspan="4" width="683">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="color: black; mso-color-alt: windowtext;">ASSIGNMENT &amp; SYSTEM DETAILS</span></p>
                          </td>
                          </tr>
                          <tr style="mso-yfti-irow: 1; height: 13.3pt;">
                          <td style="width: 144.85pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-bottom-alt: solid windowtext .5pt; mso-border-right-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 13.3pt;" width="193">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%;">PROJECT DESINATION</span></p>
                          </td>
                          <td style="width: 111.05pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-left-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; mso-border-right-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 13.3pt;" width="148">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp;{$desination}</span></p>
                          </td>
                          <td style="width: 127.95pt; border: none; border-bottom: solid windowtext 1.0pt; mso-border-left-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 13.3pt;" width="171">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%;">PROJECT LEAD TIME</span></p>
                          </td>
                          <td style="width: 128.05pt; border-top: none; border-left: solid windowtext 1.0pt; border-bottom: solid windowtext 1.0pt; border-right: none; mso-border-left-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 13.3pt;" width="171">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp; {$lead_time}</span></p>
                          </td>
                          </tr>
                          <tr style="mso-yfti-irow: 2; height: 12.9pt;">
                          <td style="width: 144.85pt; border: none; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-right-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 12.9pt;" width="193">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%;">OBJECTIVES</span></p>
                          </td>
                          <td style="width: 367.05pt; border: none; border-bottom: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 12.9pt;" colspan="3" rowspan="2" width="489">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">&nbsp; {$objectives}</span></p>
                          </td>
                          </tr>
                          <tr style="mso-yfti-irow: 3; height: 14.95pt;">
                          <td style="width: 144.85pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-bottom-alt: solid windowtext .5pt; mso-border-right-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 14.95pt;" width="193">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US">&nbsp;</span></p>
                          </td>
                          </tr>
                          <tr style="mso-yfti-irow: 4; mso-yfti-lastrow: yes; height: 19.4pt;">
                          <td style="width: 255.9pt; border: none; border-bottom: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 19.4pt;" colspan="2" valign="top" width="341">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 6.0pt; line-height: 115%;">*Listed Pricing Excludes GST</span></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 6.0pt; line-height: 115%;">&nbsp;</span></p>
                          </td>
                          <td style="width: 256.0pt; border: none; border-bottom: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-bottom-alt: solid windowtext .5pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 19.4pt;" colspan="2" valign="top" width="341">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="font-size: 6.0pt; line-height: 115%;">Further Remarks:<span lang="EN-US" style="font-size: 8.0pt; line-height: 115%; font-family: 'Abadi Extra Light',sans-serif;">{$remarks}</span></span></p>
                          </td>
                          </tr>
                          </tbody>
                          </table>
                          <p class="MsoNormal"><span lang="EN" style="font-size: 10.0pt; line-height: 107%; font-family: '微軟正黑體',sans-serif; mso-ansi-language: EN;">&nbsp;</span></p>
                      `
            },
            {
              title: 'Quotation Items',
              description: 'The quotation items table.',
              content: `<table class="MsoTableGrid" style="border-collapse: collapse; border: none; width: 100%; border-spacing: 0px; margin-left: auto; margin-right: auto;" border="1" cellspacing="0" cellpadding="0">
                      <tbody>
                      <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; mso-yfti-lastrow: yes; height: 17.5pt;">
                      <td style="width: 510.2pt; border: none; background: #D5DCE4; mso-background-themecolor: text2; mso-background-themetint: 51; padding: 0cm 0cm 0cm 0cm; height: 17.5pt;" width="680">
                      <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; mso-pagination: none; mso-layout-grid-align: none; text-autospace: none;"><span lang="EN-US" style="mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-bidi-font-family: Calibri; color: black; mso-color-alt: windowtext;">DESCRIPTION &amp; DETAILS</span></p>
                      </td>
                      </tr>
                      <tr>
                      <td style="width: 100%; border: none; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0cm;">
                      <p class="MsoNormal" style="margin-bottom: 0cm; line-height: 115%; text-align: center;"><span lang="EN-US" style="mso-ascii-font-family: Calibri; mso-hansi-font-family: Calibri; mso-bidi-font-family: Calibri; color: black; mso-color-alt: windowtext;">{$items}</span></p>
                      </td>
                      </tr>
                      </tbody>
                      </table>`
            },
            {
              title: 'Quotation footer',
              description: 'The quotation footer table.',
              content: `<div class="WordSection1">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><strong><span lang="EN-US" style="font-size: 8.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; color: black; mso-themecolor: text1;">&nbsp;</span></strong></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><strong><span lang="EN-US" style="font-size: 8.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; color: black; mso-themecolor: text1;">The validity period of this quotation is one month. Please sign and date it with an authorized signatory, and then email it to {$user_email}<span style="mso-spacerun: yes;">&nbsp; </span></span></strong></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><strong><span lang="EN-US" style="font-size: 8.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; color: black; mso-themecolor: text1;">We look forward to serving you in the near future</span></strong></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><strong><span lang="EN-US" style="font-size: 8.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; color: black; mso-themecolor: text1;">&nbsp;</span></strong></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><strong><span lang="EN-US" style="font-size: 8.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; color: black; mso-themecolor: text1;">&nbsp;</span></strong></p>
                          <table class="MsoTableGrid" style="width: 100%; border-collapse: collapse; border: none; border-spacing: 0px;" border="1" width="679" cellspacing="0" cellpadding="0">
                          <tbody>
                          <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 95.35pt;">
                          <td style="width: 254.45pt; border: none; border-right: solid windowtext 1.0pt; mso-border-right-alt: solid windowtext .5pt; padding: 5.65pt 5.4pt 5.65pt 5.4pt; height: 95.35pt;" valign="top" width="339">
                          <p class="MsoNormal" style="line-height: 115%; mso-pagination: none; tab-stops: 276.45pt; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 0cm 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">For &amp; On Behalf of {$company_name}*</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Name:</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Title:</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Signature &amp; Company Stamp</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-pagination: none; tab-stops: 276.45pt; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 0cm 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Acceptance Date:</span></p>
                          </td>
                          <td style="width: 254.5pt; border: none; mso-border-left-alt: solid windowtext .5pt; padding: 5.65pt 5.4pt 5.65pt 5.4pt; height: 95.35pt;" valign="top" width="339">
                          <p class="MsoNormal" style="line-height: 115%; mso-pagination: none; tab-stops: 276.45pt; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 0cm 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">For &amp; On Behalf of {$sender_company}*</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Name: {$user_name}</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Title: {$user_title}</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 10.0pt 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Signature &amp; Company Stamp</span></p>
                          <p class="MsoNormal" style="line-height: 115%; mso-pagination: none; tab-stops: 276.45pt; mso-layout-grid-align: none; text-autospace: none; margin: 0cm 0cm 0cm 36.0pt;"><span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">Issued Date: {$issued_date}</span></p>
                          </td>
                          </tr>
                          <tr style="height: 22.3pt;">
                          <td style="width: 508.95pt; border: none; padding: 5.65pt 5.4pt 5.65pt 5.4pt; height: 22.3pt;" colspan="2" valign="top" width="100%">
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><span lang="EN" style="font-size: 6.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; mso-ansi-language: EN;">&nbsp;</span></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><span lang="EN" style="font-size: 6.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; mso-ansi-language: EN;">&nbsp;</span></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><span lang="EN" style="font-size: 6.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; mso-ansi-language: EN;">ACKNOWLEDGEMENT</span></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><span lang="EN" style="font-size: 6.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; mso-ansi-language: EN;">This Quotation is signed between <span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">{$sender_company}</span>, and&nbsp;<span style="text-decoration: underline;"> &nbsp;<span lang="EN" style="font-size: 8.0pt; line-height: 115%; font-family: 'Arial Narrow',sans-serif; mso-bidi-font-family: 'Arial Narrow'; mso-ansi-language: EN;">{$company_name}&nbsp; </span></span>&nbsp;(the "Client") (collectively, the &lsquo;Parities ).</span></p>
                          <p class="MsoNormal" style="margin-bottom: 0cm; line-height: normal;"><span lang="EN" style="font-size: 6.0pt; mso-fareast-font-family: 微軟正黑體; mso-bidi-font-family: Calibri; mso-bidi-theme-font: minor-latin; mso-ansi-language: EN;">This Quotation conﬁrms that it has read and understood the Terms &amp; Scope of service(s) as set out in the above pages, and Parties agree that they will be bound by all obligations set out herein.</span></p>
                          </td>
                          </tr>
                          </tbody>
                          </table>
                          </div>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>`
            }
          ],
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
          };
        return {
          init: init,
        }
    },
    methods: {

    },
  });


  </script>
  <style>
      .tox-notifications-container {display: none !important;}
      .tox-statusbar__right-container .tox-statusbar__branding { display: none !important; }
  </style>
