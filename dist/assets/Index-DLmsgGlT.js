import{u as G}from"./hooks-BxjXLzY_.js";import{h as N,j as p,c as E,O as j,q as A,v as f,e as F,D as B,G as k,E as S,F as U,m as u,p as h,x as s,H,C as M,y as a,a0 as L,$ as i,w as O,A as q,B as I,Z as P,K as Q,l as Z}from"./main-B8dzZHEF.js";import{c as z,d as R,a as D}from"./index.esm-NSx9nZrM.js";import{u as J}from"./useFilm-rpeQrTzO.js";import{u as W}from"./useStudio-BinsPpb_.js";const X={class:"card bg-component text-bodydark"},Y={class:"card-header flex justify-between items-center my-2"},ee=s("i",{class:"fa-solid fa-circle-xmark"},null,-1),te={class:"card-body"},se={class:"row"},oe={class:"col-md-3 flex flex-col mb-3"},le=s("label",{class:"form-label"},"Film",-1),ae={class:"col-md-3 flex flex-col mb-3"},ne=s("label",{class:"form-label"},"Studio",-1),de={class:"col-md-3 flex flex-col mb-3"},ie=s("label",{class:"form-label"},"Start Time",-1),me={class:"col-md-3 flex flex-col mb-3"},re=s("label",{class:"form-label"},"End Time",-1),ue=s("div",{class:"card-footer flex justify-end my-3"},[s("button",{type:"submit",class:"btn btn-md btn-primary"}," Submit ")],-1),ce=N({__name:"Form",props:{selected:{type:String,default:null}},emits:["close","refresh"],setup(y,{emit:m}){const d=y,r=m,e=p({}),_=p(),x=z().shape({film_id:R().required("Film cannot be empty"),studio_id:R().required("Studio cannot be empty"),start_time:D().required("Start Time cannot be empty"),end_time:D().required("End Time cannot be empty")});function g(){B(document.getElementById("form-show_time")),k.get(`/master/show-time/${d.selected}`).then(({data:t})=>{e.value=t.data}).catch(t=>{console.error(t.response.data.message),S.error(t.response.data.message)}).finally(()=>U(document.getElementById("form-show_time")))}function V(){const t=new FormData;t.append("film_id",e.value.film_id),t.append("studio_id",e.value.studio_id),t.append("start_time",e.value.start_time),t.append("end_time",e.value.end_time),d.selected&&t.append("_method","PUT"),B(document.getElementById("form-show_time")),k({method:"post",url:d.selected?`/master/show-time/${d.selected}`:"/master/show-time/store",data:t,headers:{"Content-Type":"multipart/form-data"}}).then(()=>{S.success("Data saved successfully"),_.value.resetForm(),r("close"),r("refresh")}).catch(o=>{console.error(o.response.data.message),S.error(o.response.data.message)}).finally(()=>U(document.getElementById("form-show_time")))}const w=J(),C=E(()=>w.data.value?.map(t=>({id:t.id,text:t.title}))),$=W(),n=E(()=>$.data.value?.map(t=>({id:t.id,text:t.name})));return j(()=>{d.selected&&g()}),(t,o)=>{const c=u("select2"),b=u("Field"),v=u("ErrorMessage"),T=u("date-picker"),K=u("VForm");return h(),A(K,{"validation-schema":F(x),ref_key:"formRef",ref:_,onSubmit:V,id:"form-show_time"},{default:f(()=>[s("div",X,[s("div",Y,[s("h2",null,H(y.selected?"Edit":"Add")+" Show Time",1),s("button",{type:"button",class:"btn btn-md btn-danger",onClick:o[0]||(o[0]=l=>t.$emit("close"))},[ee,M(" Cancel ")])]),s("div",te,[s("div",se,[s("div",oe,[le,a(b,{name:"film_id",modelValue:e.value.film_id,"onUpdate:modelValue":o[2]||(o[2]=l=>e.value.film_id=l),class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-2.5",placeholder:"Select Film"},{default:f(()=>[a(c,{options:C.value,modelValue:e.value.film_id,"onUpdate:modelValue":o[1]||(o[1]=l=>e.value.film_id=l),class:"form-select-solid",placeholder:"Select Film"},null,8,["options","modelValue"])]),_:1},8,["modelValue"]),a(v,{name:"film_id",class:"text-red-500"})]),s("div",ae,[ne,a(b,{name:"studio_id",modelValue:e.value.studio_id,"onUpdate:modelValue":o[4]||(o[4]=l=>e.value.studio_id=l),class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-2.5",placeholder:"Select Film"},{default:f(()=>[a(c,{options:n.value,modelValue:e.value.studio_id,"onUpdate:modelValue":o[3]||(o[3]=l=>e.value.studio_id=l),class:"form-select-solid",placeholder:"Select Film"},null,8,["options","modelValue"])]),_:1},8,["modelValue"]),a(v,{name:"studio_id",class:"text-red-500"})]),s("div",de,[ie,a(b,{name:"start_time",autocomplete:"off",modelValue:e.value.start_time,"onUpdate:modelValue":o[6]||(o[6]=l=>e.value.start_time=l),class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-2.5",placeholder:"Insert Start Time"},{default:f(()=>[a(T,{modelValue:e.value.start_time,"onUpdate:modelValue":o[5]||(o[5]=l=>e.value.start_time=l),class:"rounded py-2.5",config:{enableTime:!0,noCalendar:!0,dateFormat:"H:i"}},null,8,["modelValue"])]),_:1},8,["modelValue"]),a(v,{name:"start_time",class:"text-red-500"})]),s("div",me,[re,a(b,{name:"end_time",autocomplete:"off",modelValue:e.value.end_time,"onUpdate:modelValue":o[8]||(o[8]=l=>e.value.end_time=l),class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-2.5",placeholder:"Insert End Time"},{default:f(()=>[a(T,{modelValue:e.value.end_time,"onUpdate:modelValue":o[7]||(o[7]=l=>e.value.end_time=l),class:"rounded py-2.5",config:{enableTime:!0,noCalendar:!0,dateFormat:"H:i"}},null,8,["modelValue"])]),_:1},8,["modelValue"]),a(v,{name:"end_time",class:"text-red-500"})])])]),ue])]),_:1},8,["validation-schema"])}}}),fe={class:"border-b-[1px] border-body pb-3"},pe={class:"w-full h-full flex flex-col rounded-xl space-y-4"},_e={class:"border-b-[1px] border-body flex justify-between items-center p-4"},be={class:"flex items-center gap-3"},ve=s("i",{class:"la la-arrow-left"},null,-1),he=[ve],ye={class:"text-xl"},xe=s("i",{class:"las la-plus"},null,-1),ge={class:"w-full h-full py-2 px-4"},Fe=N({__name:"Index",setup(y){const m=P(),d=p(null),r=p(""),e=p(!1),_=Q(),x=Z(),{data:g,refetch:V}=L({queryKey:["films"],queryFn:async()=>await k.get(`/master/film/${_.params.uuid}`).then(n=>n.data.data)}),{delete:w}=G({onSuccess:()=>d?.value.refetch()}),C=[m.accessor("no",{header:"No"}),m.accessor("film.title",{header:"Film"}),m.accessor("studio",{header:"Studio",cell:n=>i("div",{class:"flex gap-2"},[i("span",{class:"text-sm"},n.getValue().name),i("span",{class:"text-sm"}," - "),i("span",{class:"text-sm"},n.getValue().cinema.name)])}),m.accessor("start_time",{header:"Start Time"}),m.accessor("end_time",{header:"End Time"}),m.accessor("uuid",{header:"Action",cell:n=>i("div",{class:"flex gap-4"},[i("button",{class:"btn btn-sm btn-info",onClick:()=>{r.value=n.getValue(),e.value=!0}},[i("i",{class:"la la-pencil fs-2"})]),i("button",{class:"btn btn-sm btn-danger",onClick:()=>w(`/master/show-time/${n.getValue()}`)},[i("i",{class:"las la-trash fs-2"})])])})],$=()=>d.value?.refetch();return O(e,()=>{e.value||(r.value=""),window.scrollTo(0,0)}),j(()=>V()),(n,t)=>{const o=u("paginate");return h(),q("main",fe,[e.value?(h(),A(ce,{key:0,selected:r.value,onClose:t[0]||(t[0]=c=>e.value=!1),onRefresh:$},null,8,["selected"])):I("",!0),s("div",pe,[s("div",_e,[s("div",be,[s("button",{type:"button",class:"btn btn-sm btn-icon hover:text-blue-700 hover:bg-slate-900 text-bodydark bg-slate-800",onClick:t[1]||(t[1]=c=>F(x).push({name:"master.film"}))},he),s("h2",ye,H(F(g)?.title)+" Show Time List",1)]),e.value?I("",!0):(h(),q("button",{key:0,type:"button",onClick:t[2]||(t[2]=c=>e.value=!0),class:"btn btn-md btn-primary"},[xe,M(" Add ")]))]),s("div",ge,[a(o,{ref_key:"paginateRef",ref:d,url:"/master/show-time",id:"table-show-time",payload:{uuid_film:n.$route.params.uuid_film,uuid_studio:n.$route.params.uuid_studio},columns:C},null,8,["payload"])])])])}}});export{Fe as default};