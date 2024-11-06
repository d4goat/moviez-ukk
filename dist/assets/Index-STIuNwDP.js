import{u as I}from"./hooks-BxjXLzY_.js";import{a0 as M,G as V,h as N,j as p,c as R,O as T,q as S,v as $,e as U,D as w,E as C,F as B,m as f,p as y,x as e,H as j,C as q,y as c,$ as u,w as H,A as E,B as F,Z as G}from"./main-B8dzZHEF.js";import{c as K,a as k}from"./index.esm-NSx9nZrM.js";function L(m={}){return M({queryKey:["cities"],queryFn:async()=>await V.get("/indonesia/cities").then(o=>o.data.data),...m})}const O={class:"card bg-dark-bg shadow-3 shadow-white text-bodydark1"},P={class:"card-header align-items-center flex justify-between my-3"},Q=e("i",{class:"fa-solid fa-circle-xmark"},null,-1),Z={class:"card-body"},z={class:"row"},J={class:"col-md-4 flex flex-col mb-3"},W=e("label",{class:"form-label"},"Name",-1),X={class:"col-md-4 flex flex-col mb-3"},Y=e("label",{class:"form-label required"},"City",-1),ee={class:"col-md-4 flex flex-col mb-3"},te=e("label",{class:"form-label"},"Address",-1),se=e("div",{class:"card-footer flex"},[e("button",{type:"submit",class:"btn btn-md my-3 ms-auto btn-primary text-white"},"Submit")],-1),ae=N({__name:"Form",props:{selected:{type:String,default:null}},emits:["close","refresh"],setup(m,{emit:o}){const l=m,r=o,t=p({}),b=p(),h=K().shape({name:k().required("Name cannot be empty"),city:k().required("City cannot be empty"),address:k().required("Address cannot be empty")});function v(){w(document.getElementById("form-cinema")),V.get(`/master/cinema/${l.selected}`).then(({data:s})=>{t.value=s.data}).catch(s=>C.error(s.response.data.message)).finally(()=>B(document.getElementById("form-cinema")))}function d(){const s=new FormData;s.append("name",t.value.name),s.append("city",t.value.city),s.append("address",t.value.address),w(document.getElementById("form-cinema")),l.selected&&s.append("_method","PUT"),V({method:"post",url:l.selected?`/master/cinema/${l.selected}`:"/master/cinema/store",data:s,headers:{"Content-Type":"multipart/form-data"}}).then(()=>{C.success("Success create data cinema"),b.value.resetForm(),r("close"),r("refresh")}).catch(a=>{C.error(a.response.data.message),console.error(a.response.data.message)}).finally(()=>B(document.getElementById("form-cinema")))}const i=L(),_=R(()=>i.data.value?.map(s=>({id:s.code,text:s.name})));return T(()=>{l.selected&&v()}),(s,a)=>{const g=f("Field"),x=f("ErrorMessage"),A=f("select2"),D=f("VForm");return y(),S(D,{onSubmit:d,"validation-schema":U(h),ref_key:"formRef",ref:b,id:"form-cinema"},{default:$(()=>[e("div",O,[e("div",P,[e("h2",null,j(m.selected?"Edit":"Tambah")+" Cinema ",1),e("button",{type:"button",class:"btn btn-md btn-danger",onClick:a[0]||(a[0]=n=>s.$emit("close"))},[Q,q(" Batal ")])]),e("div",Z,[e("div",z,[e("div",J,[W,c(g,{autocomplete:"off",name:"name",type:"text",placeholder:"Masukkan Cinema Name",class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-3",modelValue:t.value.name,"onUpdate:modelValue":a[1]||(a[1]=n=>t.value.name=n)},null,8,["modelValue"]),c(x,{name:"name",class:"text-red-500"})]),e("div",X,[Y,c(g,{autocomplete:"off",name:"city",class:"form-control form-control-solid",modelValue:t.value.city,"onUpdate:modelValue":a[3]||(a[3]=n=>t.value.city=n)},{default:$(()=>[c(A,{class:"form-select-solid",placeholder:"Select Cinema City",options:_.value,modelValue:t.value.city,"onUpdate:modelValue":a[2]||(a[2]=n=>t.value.city=n)},null,8,["options","modelValue"])]),_:1},8,["modelValue"]),c(x,{name:"city",class:"text-red-500"})]),e("div",ee,[te,c(g,{autocomplete:"off",name:"address",type:"text",placeholder:"Masukkan Cinema Address",class:"bg-[#232323] border-none focus:ring-[#7C7C7C] rounded-xl p-3",modelValue:t.value.address,"onUpdate:modelValue":a[4]||(a[4]=n=>t.value.address=n)},null,8,["modelValue"]),c(x,{name:"address",class:"text-red-500"})])])]),se])]),_:1},8,["validation-schema"])}}}),oe={class:"border-b-[1px] border-body pb-3"},le={class:"w-full h-full flex-col rounded-lg space-y-4"},ne={class:"border-b-[1px] border-body flex justify-between items-center p-4"},ce=e("h2",{class:"text-xl"},"Cinemas List",-1),de=e("i",{class:"fa-solid fa-plus"},null,-1),re={class:"w-full h-full py-2 px-4"},fe=N({__name:"Index",setup(m){const o=G(),l=p(null),r=p(""),t=p(!1),{delete:b}=I({onSuccess:()=>l.value.refetch()}),h=[o.accessor("no",{header:"No"}),o.accessor("name",{header:"Name"}),o.accessor("city",{header:"City"}),o.accessor("address",{header:"Address"}),o.accessor("uuid",{header:"Action",cell:d=>u("div",{class:"flex gap-2"},[u("button",{class:"btn btn-sm bg-purple-400 hover:bg-purple-600",onClick:()=>{r.value=d.getValue(),t.value=!0}},u("i",{class:"la la-pencil fs-2"})),u("button",{class:"btn btn-sm bg-red-400 hover:bg-red-600",onClick:()=>{b(`/master/cinema/${d.getValue()}`)}},u("i",{class:"la la-trash fs-2"}))])})],v=()=>l.value.refetch();return H(t,d=>{d||(r.value=""),window.scrollTo(0,0)}),(d,i)=>{const _=f("paginate");return y(),E("div",oe,[t.value?(y(),S(ae,{key:0,selected:r.value,onClose:i[0]||(i[0]=s=>t.value=!1),onRefresh:v},null,8,["selected"])):F("",!0),e("div",le,[e("div",ne,[ce,t.value?F("",!0):(y(),E("button",{key:0,type:"button",class:"bg-blue-600 text-bodydark1 py-2 px-4 rounded hover:bg-blue-700",onClick:i[1]||(i[1]=s=>t.value=!0)},[q(" Add "),de]))]),e("div",re,[c(_,{ref_key:"paginateRef",ref:l,id:"table-cinemas",url:"/master/cinema",columns:h},null,512)])])])}}});export{fe as default};