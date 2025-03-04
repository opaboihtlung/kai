import{o as _,c as y,w as h,g as t,n as g,a as o,h as a,k as x,u as b,t as n,v as C,r as k,e as p,f as q,F as j,C as P}from"./app-CD2aFJMz.js";import{Q as $}from"./QLayout-BZLnjnEC.js";import{_ as Q}from"./MainLayout-BhDzJCbe.js";import{S as w}from"./index.es-CSlFEJh2.js";import{C as m}from"./ClosePopup-BBeWmOkr.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./use-quasar-B6weMyZ6.js";const B={class:"print-hide flex justify-between items-center"},S=t("div",{class:"text-lg text-weight-medium"},"Print QR",-1),V={class:"column justify-between items-center"},D=t("br",null,null,-1),L={class:"text-lg text-weight-medium print-only"},R={class:"text-md print-only"},F={class:"flex justify-end q-gutter-sm"},G={__name:"QrPrint",props:["office"],setup(u){const s=u,r=l=>{window.print()};return(l,f)=>(_(),y(C,{style:{width:"450px"},class:"q-pa-sm"},{default:h(()=>{var e,c,i,d,v;return[t("div",B,[S,g(o(a,{size:"sm",round:"",outline:"",icon:"close"},null,512),[[m]])]),o(x,{class:"q-my-sm"}),t("div",V,[o(b(w),{width:250,height:250,value:(c=(e=s==null?void 0:s.office)==null?void 0:e.qr_code)==null?void 0:c.code},null,8,["value"]),D,t("div",L,n((i=s==null?void 0:s.office)==null?void 0:i.name),1),t("div",R,n((v=(d=s==null?void 0:s.office)==null?void 0:d.district)==null?void 0:v.name),1)]),o(x,{class:"q-my-sm"}),t("div",F,[o(a,{class:"print-hide",onClick:r,color:"primary",label:"Print"}),g(o(a,{class:"print-hide",color:"negative",outline:"",label:"Close"},null,512),[[m]])])]}),_:1}))}},N=t("div",{class:"flex justify-between items-center"},[t("div",null,[t("div",{class:"text-title"},"Configuration")]),t("div")],-1),T=t("br",null,null,-1),z={class:"row q-col-gutter-sm"},E={class:"col-xs-12 col-sm-6"},I={class:"shadow-default bg-white q-pa-md"},M={class:"flex justify-between"},O={class:"flex items-center q-gutter-sm"},U={class:"text-lg"},A={class:"text-md text-grey-7"},H=t("br",null,null,-1),J={class:"flex justify-between items-center"},K=t("div",{class:"text-md text-grey-7"},"Latitude",-1),W={class:"text-md text-bold"},X={class:"flex justify-between items-center"},Y=t("div",{class:"text-md text-grey-7"},"Longtitude",-1),Z={class:"text-md text-bold"},tt={class:"flex justify-between items-center"},et=t("div",{class:"text-md text-grey-7"},"Radius (Geofence)",-1),st={class:"text-md text-bold"},ot={class:"flex justify-between items-center"},nt=t("div",{class:"text-md text-grey-7"},"Starting Time",-1),lt={class:"text-md text-bold"},ct={class:"flex justify-between items-center"},it=t("div",{class:"text-md text-grey-7"},"Closing Time",-1),dt={class:"text-md text-bold"},at={class:"flex justify-between items-center"},rt=t("div",{class:"text-md text-grey-7"},"Grace Period",-1),_t={class:"text-md text-bold"},ut={class:"flex q-gutter-sm"},wt=Object.assign({layout:Q},{__name:"Index",props:["offices"],setup(u){const s=k({selected:null,openPrint:!1}),r=l=>{console.log(l),s.selected=l,s.openPrint=!0};return(l,f)=>(_(),y($,{padding:"",class:"container"},{default:h(()=>[N,T,t("div",z,[(_(!0),p(j,null,q(u.offices,e=>{var c,i;return _(),p("div",E,[t("div",I,[t("div",M,[t("div",O,[t("div",null,[o(b(w),{onClick:d=>r(e),width:60,height:60,value:(c=e==null?void 0:e.qr_code)==null?void 0:c.code},null,8,["onClick","value"])]),t("div",null,[t("div",U,n(e==null?void 0:e.name),1),t("div",A,n((i=e==null?void 0:e.district)==null?void 0:i.name),1)])]),o(a,{onClick:d=>l.$inertia.get(l.route("config.edit",e.id)),class:"q-pa-none q-ma-none text-grey-7",icon:"o_settings"},null,8,["onClick"])]),H,t("div",J,[K,t("div",W,n(e==null?void 0:e.lat),1)]),t("div",X,[Y,t("div",Z,n(e==null?void 0:e.lng),1)]),t("div",tt,[et,t("div",st,n(e==null?void 0:e.radius)+" Meter",1)]),t("div",ot,[nt,t("div",lt,n(e==null?void 0:e.start_time),1)]),t("div",ct,[it,t("div",dt,n(e==null?void 0:e.close_time),1)]),t("div",at,[rt,t("div",_t,n(e==null?void 0:e.grace_period),1)]),o(x,{class:"q-my-sm"}),t("div",ut,[o(a,{color:"dark",onClick:d=>r(e),icon:"o_print",label:"Print QR"},null,8,["onClick"])])])])}),256))]),o(P,{modelValue:s.openPrint,"onUpdate:modelValue":f[0]||(f[0]=e=>s.openPrint=e)},{default:h(()=>[o(G,{office:s.selected},null,8,["office"])]),_:1},8,["modelValue"])]),_:1}))}});export{wt as default};
