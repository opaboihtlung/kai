import{T as h,o as k,c as N,w as v,a as t,Q as m,u as r,g as s,h as y}from"./app-CD2aFJMz.js";import{Q as S}from"./QForm-BBfP4Z3U.js";import{Q as q}from"./QLayout-BZLnjnEC.js";import{_ as x}from"./MainLayout-BhDzJCbe.js";import{u as B}from"./use-quasar-B6weMyZ6.js";import"./selection-BtuRkBgR.js";import"./FooterComponent-yubzXBYP.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const C=s("div",{class:"flex justify-between"},[s("div",null,[s("div",{class:"text-title"},"Profile")])],-1),U=s("br",null,null,-1),D={class:"flex q-gutter-sm"},T=Object.assign({layout:x},{__name:"Edit",props:["data"],setup(w){const u=w,a=B(),e=h({full_name:u.data.full_name,designation:u.data.designation,mobile:u.data.mobile}),Q=n=>{n.preventDefault(),a.dialog({title:"Confirmation",message:"Do you want to update?",ok:"Yes",cancel:"No"}).onOk(()=>{a.loading.show(),e.put(route("profile.update"),{onSuccess:()=>{a.loading.hide(),a.notify({type:"positive",message:"Profile updated successfully!"})},onError:o=>{var i;a.loading.hide(),console.error(o),a.notify({type:"negative",message:((i=o==null?void 0:o.mobile)==null?void 0:i[0])||"Error updating profile!"})}})})};return(n,o)=>(k(),N(q,{padding:"",class:"container-sm"},{default:v(()=>[C,U,t(S,{onSubmit:Q},{default:v(()=>{var i,d,g,p,f,b,c,_,V;return[t(m,{modelValue:r(e).full_name,"onUpdate:modelValue":o[0]||(o[0]=l=>r(e).full_name=l),outlined:"",label:"Full Name","bg-color":"white",error:!!((i=r(e).errors)!=null&&i.full_name),"error-message":(g=(d=r(e).errors)==null?void 0:d.full_name)==null?void 0:g.toString(),rules:[l=>!!l||"Full Name is required"]},null,8,["modelValue","error","error-message","rules"]),t(m,{modelValue:r(e).designation,"onUpdate:modelValue":o[1]||(o[1]=l=>r(e).designation=l),outlined:"",label:"Designation","bg-color":"white",error:!!((p=r(e).errors)!=null&&p.designation),"error-message":(b=(f=r(e).errors)==null?void 0:f.designation)==null?void 0:b.toString()},null,8,["modelValue","error","error-message"]),t(m,{modelValue:r(e).mobile,"onUpdate:modelValue":o[2]||(o[2]=l=>r(e).mobile=l),outlined:"",mask:"##########",label:"Mobile","bg-color":"white",error:!!((c=r(e).errors)!=null&&c.mobile),"error-message":(V=(_=r(e).errors)==null?void 0:_.mobile)==null?void 0:V.toString(),rules:[l=>!!l||"Mobile is required",l=>l.length===10||"Invalid Mobile No"]},null,8,["modelValue","error","error-message","rules"]),s("div",D,[t(y,{type:"submit",color:"primary",label:"Update"}),t(y,{color:"negative",outline:"",label:"Cancel",onClick:o[3]||(o[3]=l=>n.$inertia.replace(n.route("dashboard")))})])]}),_:1})]),_:1}))}});export{T as default};
