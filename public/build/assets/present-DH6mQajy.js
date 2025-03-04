import{r as N,o as i,c as r,w as a,g as e,a as t,d as c,t as d,i as b,e as w,f as T,F as B,u,b as I,Q as O,h as f,O as y,Z as g,m as A}from"./app-CD2aFJMz.js";import{_ as D,a as L,b as v,c as k,Q as V}from"./MainLayout-BhDzJCbe.js";import{Q as F}from"./QSpace-BqO1vlbS.js";import{Q as q}from"./QChip-BKFdpbUD.js";import{Q as P}from"./QLayout-BZLnjnEC.js";import{u as E}from"./use-quasar-B6weMyZ6.js";import{u as K}from"./utils-f6ewzwJT.js";import{_ as U}from"./KaiCalendar-BolKCiKJ.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./date-BNbFJ6l6.js";import"./QDate-DQAHrZCw.js";import"./use-cache-hsIl6Ivw.js";const Y={class:"row q-col-gutter-sm"},Z={class:"col-xs-12 col-sm-4"},G={class:"column q-pa-sm bg-white"},H={class:"text-center"},J={class:"text-weight-medium text-dark"},M={class:"text-weight-medium text-grey-7 q-ma-none"},R={class:"col-xs-12 col-sm-8 row q-col-gutter-sm"},W={class:"bg-primary q-pa-sm shadow-default text-white card"},X={class:"flex justify-between items-center"},ee={class:"text-xl text-bold"},te=e("div",{class:"text-md text-grey-2"},"No of officials",-1),se={class:"bg-positive q-pa-sm shadow-default text-white card"},ae={class:"flex justify-between items-center"},oe={class:"text-xl text-bold"},ne=e("div",{class:"text-md text-grey-2"},"Present on Today's",-1),le={class:"bg-negative q-pa-sm shadow-default text-white card"},ie={class:"flex justify-between items-center"},ce={class:"text-xl text-bold"},de=e("div",{class:"text-md text-grey-2"},"Absent on Today's",-1),re={class:"bg-blue q-pa-sm shadow-default text-white card"},ue={class:"flex justify-between items-center"},_e=e("div",{class:"text-xl text-bold"},"E-Leave",-1),me=e("div",{class:"text-md text-grey-2"},"Leave on Today's",-1),he={class:"col-xs-12"},fe={class:"q-pa-sm row"},ge=e("div",{class:"text-lg text-bold text-dark"},"Today's Attendences",-1),ve={class:"flex justify-between items-center shadow-default q-mt-sm bg-white q-pa-sm"},xe={class:"flex items-center q-gutter-sm"},pe={class:"q-ml-sm"},be={class:"text-bold text-weight-medium"},we={class:"text-grey-7 text-weight-medium"},ye={class:"flex q-gutter-sm items-center"},ke={class:"flex q-gutter-sm"},De=Object.assign({layout:D},{__name:"present",props:["user","devices","attendances","current_sessions","total_users","noOfLeave","count_attendances","search"],setup(o){const _=o,x=E(),{formatSignoutTime:Q,formatDateTime:$}=K(),j=l=>{x.dialog({title:"Confirmation",message:"Do you want to sign out this session?",ok:"Yes",cancel:"No"}).onOk(()=>{y.delete(route("attendance.signout",l.id),{onStart:n=>x.loading.show(),onFinish:n=>x.loading.hide()})})},C=async l=>{if(l){const n=await y.get(l,{},{preserveState:!0});_.attendances=n.props.attendances}},m=N({search:_==null?void 0:_.search,selected:null}),z=l=>{var n;y.get(route("dashboard.present"),{office_ids:(n=m.offices)==null?void 0:n.map(h=>h.value),...m})};return(l,n)=>(i(),r(P,{class:"container",padding:""},{default:a(()=>{var h,S;return[e("div",Y,[e("div",Z,[e("div",G,[e("div",H,[t(c,{size:"32px",name:"o_account_circle"}),e("div",J,d((h=o.user)==null?void 0:h.full_name),1),e("div",M,d((S=o.user)==null?void 0:S.designation),1)]),t(V,{class:"q-pa-none",separator:""},{default:a(()=>[t(L,null,{default:a(()=>[t(v,null,{default:a(()=>[t(k,{class:"text-dark text-lg"},{default:a(()=>[b("Active Sessions")]),_:1})]),_:1})]),_:1}),(i(!0),w(B,null,T(o.current_sessions,s=>(i(),r(L,{key:s.id,class:"q-pl-none"},{default:a(()=>[t(v,{avatar:""},{default:a(()=>[t(c,{name:"error_outline",color:"warning"})]),_:1}),t(v,null,{default:a(()=>[t(k,null,{default:a(()=>[b(d(u($)(s==null?void 0:s.signin_at)),1)]),_:2},1024)]),_:2},1024),t(v,{side:""},{default:a(()=>[t(k,{style:{"font-style":"italic","font-size":"13px"}},{default:a(()=>[b("Sign out")]),_:1}),t(f,{onClick:p=>j(s),round:"",icon:"logout"},null,8,["onClick"])]),_:2},1024)]),_:2},1024))),128))]),_:1})]),t(U,{class:"full-width"})]),e("div",R,[t(u(g),{href:l.route("dashboard.totalofficial"),class:"col-xs-12 col-sm-3 custom-link"},{default:a(()=>[e("div",W,[e("div",X,[e("div",ee,d(o.total_users),1),t(c,{size:"24px",name:"people_outline"})]),te])]),_:1},8,["href"]),t(u(g),{href:l.route("dashboard.present"),class:"col-xs-12 col-sm-3 custom-link"},{default:a(()=>[e("div",se,[e("div",ae,[e("div",oe,d(o.count_attendances),1),t(c,{size:"24px",name:"o_group_add"})]),ne])]),_:1},8,["href"]),t(u(g),{href:l.route("dashboard.absent"),class:"col-xs-12 col-sm-3 custom-link"},{default:a(()=>[e("div",le,[e("div",ie,[e("div",ce,d(o.total_users-o.count_attendances),1),t(c,{size:"24px",name:"o_group_remove"})]),de])]),_:1},8,["href"]),t(u(g),{href:l.route("dashboard.leave"),class:"col-xs-12 col-sm-3 custom-link"},{default:a(()=>[e("div",re,[e("div",ue,[_e,t(c,{size:"24px",name:"event_busy"})]),me])]),_:1},8,["href"]),e("div",he,[e("div",fe,[ge,t(F),t(O,{modelValue:m.search,"onUpdate:modelValue":n[0]||(n[0]=s=>m.search=s),autofocus:"",outlined:"",dense:"",onKeyup:I(z,["enter"]),"bg-color":"white",placeholder:"Type name...."},{append:a(()=>[t(c,{name:"o_search"})]),_:1},8,["modelValue"])]),t(V,null,{default:a(()=>[(i(!0),w(B,null,T(o.attendances.data,s=>{var p;return i(),w("div",ve,[e("div",null,[e("div",xe,[s.type==="present"?(i(),r(c,{key:0,class:"q-pa-sm",name:"fiber_manual_record",color:"positive"})):(i(),r(c,{key:1,class:"q-pa-sm",name:"fiber_manual_record",color:"warning"})),e("div",pe,[e("div",be,d((p=s==null?void 0:s.user)==null?void 0:p.full_name),1),e("div",we,"Signin at: "+d(u(Q)(s==null?void 0:s.signin_at)),1)])])]),e("div",null,[s.type==="late"?(i(),r(q,{key:0,"text-color":"white",color:"warning",label:"Late"})):(i(),r(q,{key:1,color:"positive","text-color":"white",label:"Present"}))]),e("div",ye,[s!=null&&s.signout_at?(i(),r(q,{key:0,square:"",label:u(Q)(s==null?void 0:s.signout_at)},null,8,["label"])):A("",!0),t(f,{onClick:qe=>l.$inertia.get(l.route("attendance.show",s.id)),round:"",flat:"",icon:"o_chevron_right"},null,8,["onClick"])])])}),256)),e("div",ke,[t(f,{color:"primary",onClick:n[1]||(n[1]=s=>C(o.attendances.prev_page_url)),disable:!o.attendances.prev_page_url,round:"",flat:"",icon:"o_chevron_left"},null,8,["disable"]),t(f,{color:"primary",onClick:n[2]||(n[2]=s=>C(o.attendances.next_page_url)),disable:!o.attendances.next_page_url,round:"",flat:"",icon:"o_chevron_right"},null,8,["disable"])])]),_:1})])])])]}),_:1}))}});export{De as default};
