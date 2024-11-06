import{S as D,s as L,g as T,n as K,c as O,u as z,r as H,a as G,w as P,o as J,t as Q,b as W,d as X,e as x,i as Y,f as Z,h as j,j as w,k as ee,l as F,m as v,p as h,q as R,v as C,x as e,y as u,z as V,A as y,B as _,C as E,D as A,E as S,F as B,G as U,H as q,T as te,I as se,J as oe,K as ae}from"./main-B8dzZHEF.js";import{c as I,a as g,b as le}from"./index.esm-NSx9nZrM.js";import{u as ne}from"./useSetting-BwBv7xyq.js";class re extends D{constructor(t,s){super(),this.client=t,this.setOptions(s),this.bindMethods(),this.updateResult()}bindMethods(){this.mutate=this.mutate.bind(this),this.reset=this.reset.bind(this)}setOptions(t){var s;const n=this.options;this.options=this.client.defaultMutationOptions(t),L(n,this.options)||this.client.getMutationCache().notify({type:"observerOptionsUpdated",mutation:this.currentMutation,observer:this}),(s=this.currentMutation)==null||s.setOptions(this.options)}onUnsubscribe(){if(!this.hasListeners()){var t;(t=this.currentMutation)==null||t.removeObserver(this)}}onMutationUpdate(t){this.updateResult();const s={listeners:!0};t.type==="success"?s.onSuccess=!0:t.type==="error"&&(s.onError=!0),this.notify(s)}getCurrentResult(){return this.currentResult}reset(){this.currentMutation=void 0,this.updateResult(),this.notify({listeners:!0})}mutate(t,s){return this.mutateOptions=s,this.currentMutation&&this.currentMutation.removeObserver(this),this.currentMutation=this.client.getMutationCache().build(this.client,{...this.options,variables:typeof t<"u"?t:this.options.variables}),this.currentMutation.addObserver(this),this.currentMutation.execute()}updateResult(){const t=this.currentMutation?this.currentMutation.state:T(),s={...t,isLoading:t.status==="loading",isSuccess:t.status==="success",isError:t.status==="error",isIdle:t.status==="idle",mutate:this.mutate,reset:this.reset};this.currentResult=s}notify(t){K.batch(()=>{if(this.mutateOptions&&this.hasListeners()){if(t.onSuccess){var s,n,o,c;(s=(n=this.mutateOptions).onSuccess)==null||s.call(n,this.currentResult.data,this.currentResult.variables,this.currentResult.context),(o=(c=this.mutateOptions).onSettled)==null||o.call(c,this.currentResult.data,null,this.currentResult.variables,this.currentResult.context)}else if(t.onError){var r,m,p,d;(r=(m=this.mutateOptions).onError)==null||r.call(m,this.currentResult.error,this.currentResult.variables,this.currentResult.context),(p=(d=this.mutateOptions).onSettled)==null||p.call(d,void 0,this.currentResult.error,this.currentResult.variables,this.currentResult.context)}}t.listeners&&this.listeners.forEach(({listener:l})=>{l(this.currentResult)})})}}function ie(b,t,s){var n;const o=O(()=>ue(b,t,s)),c=(n=o.value.queryClient)!=null?n:z(o.value.queryClientKey),r=new re(c,c.defaultMutationOptions(o.value)),m=H(r.getCurrentResult()),p=r.subscribe(a=>{G(m,a)}),d=(a,i)=>{r.mutate(a,i).catch(()=>{})};P(o,()=>{r.setOptions(c.defaultMutationOptions(o.value))}),J(()=>{p()});const l=Q(W(m));return P(()=>m.error,a=>{if(a&&X(o.value.useErrorBoundary,[a]))throw a}),{...l,mutate:d,mutateAsync:m.mutate,reset:m.reset}}function ue(b,t,s){const n=x(b),o=x(t);let c=n;return Y(n)&&(typeof o=="function"?c={...x(s),mutationKey:n,mutationFn:o}:c={...o,mutationKey:n}),typeof n=="function"&&(c={...o,mutationFn:n}),Z(c)}const ce={class:"w-full max-w-md lg:max-w-lg flex flex-col justify-center rounded-xl space-y-6 p-6"},de=e("div",{class:"font-medium text-center mb-4 flex flex-col"},[e("span",{class:"text-2xl sm:text-3xl"},"Login"),e("i",{class:"text-3xl sm:text-4xl text-cinema"},"Cinema51")],-1),me={class:"flex flex-col gap-6"},fe={class:"flex flex-col gap-2"},pe=e("label",{class:"text-base sm:text-lg font-poppins"},"Email",-1),xe={class:"flex flex-col gap-1"},he={class:"flex flex-col gap-2"},ve=e("label",{class:"text-base sm:text-lg font-poppins"},"Password",-1),_e={class:"relative flex flex-col gap-1"},be={class:"flex relative flex-col"},ge={class:"absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"},we={class:"flex w-full justify-center mt-4"},ye=["disable"],Ce={key:0,class:"animate-spin h-7 w-7 mx-2",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},ke=e("path",{class:"opacity-75",fill:"white",d:"M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"},null,-1),Me=[ke],Re={key:1},Ve={class:"flex w-full justify-center text-center text-sm sm:text-base"},Ee=e("br",null,null,-1),Se=j({__name:"SignIn",setup(b){const t=w(),s=w({}),n=ee(),o=w(!1),c=F(),r=I().shape({email:g().email("Invalid Email").required().label("Email"),password:g().min(8,"Password minimal harus diisi 8 karakter").required().label("Password")}),{mutate:m,isLoading:p,isSuccess:d}=ie(a=>U.post("/auth/login",a),{onMutate:()=>{A(document.getElementById("form-login"))},onSuccess:async a=>{S.success("Login berhasil!"),n.setAuth(a.data.user,a.data.token),a.data.user.role.id===1?c.push("/admin/dashboard"):c.push("/landing/dashboard")},onError:a=>{S.error(a.response.data.message)},onSettled:()=>{B(document.getElementById("form-login"))}});function l(a){const i=document.querySelector(["input[name=password]"]);i&&i.type==="password"?(i.type="text",o.value=!0):i&&(i.type="password",o.value=!1)}return(a,i)=>{const k=v("Field"),M=v("ErrorMessage"),f=v("router-link"),N=v("VForm");return h(),R(N,{"validation-schema":x(r),ref_key:"formRef",ref:t,id:"form-login",onSubmit:x(m),class:"flex justify-center bg-[#171717] items-center min-h-screen w-full p-4"},{default:C(()=>[e("div",ce,[de,e("div",me,[e("div",fe,[pe,e("div",xe,[u(k,{autocomplete:"off",class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base",name:"email",type:"email",placeholder:"Masukkan Email Anda",modelValue:s.value.email,"onUpdate:modelValue":i[0]||(i[0]=$=>s.value.email=$)},null,8,["modelValue"]),u(M,{class:"text-red-500 text-sm",name:"email"})])]),e("div",he,[ve,e("div",_e,[e("div",be,[u(k,{autocomplete:"off",class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base",name:"password",type:"password",placeholder:"Masukkan Password Anda",modelValue:s.value.password,"onUpdate:modelValue":i[1]||(i[1]=$=>s.value.password=$)},null,8,["modelValue"]),e("span",ge,[e("i",{class:V(["fa-regular text-lg sm:text-xl",{"fa-eye":o.value,"fa-eye-slash":!o.value}]),onClick:l},null,2)])]),u(M,{class:"text-red-500 text-sm",name:"password"})])]),e("div",we,[e("button",{type:"submit",disable:x(p),class:V(["bg-cinema py-2.5 w-full sm:w-1/3 rounded-lg text-white text-md sm:text-base",x(p)?"flex p-2 justify-center":"block"])},[x(p)?(h(),y("svg",Ce,Me)):_("",!0),x(p)?_("",!0):(h(),y("span",Re,"Login"))],10,ye)]),e("div",Ve,[e("span",null,[E("Don't have an account yet? "),u(f,{to:{name:"sign-up"},class:"text-cinema"},{default:C(()=>[Ee,E(" Register Now")]),_:1})])])])])]),_:1},8,["validation-schema","onSubmit"])}}}),$e={class:"w-full max-w-sm md:max-w-md lg:max-w-lg flex flex-col justify-center md:space-y-2 sm:space-y-6"},je={class:"font-medium text-center flex flex-col mb-3"},Pe=e("span",{class:"text-lg sm:text-xl"},"Registrasi",-1),qe={class:"text-2xl sm:text-3xl text-cinema"},Oe={class:"flex flex-col gap-4"},Fe={key:0},Ae={class:"flex flex-col gap-2 mb-3"},Be=e("label",{class:"text-sm sm:text-base font-poppins"},"Nama",-1),Ue={class:"flex flex-col"},Ie={class:"flex flex-col gap-2 mb-3"},Ne=e("label",{class:"text-sm sm:text-base font-medium"},"Email",-1),De={class:"flex flex-col"},Le={class:"flex flex-col gap-2 mb-3"},Te=e("label",{class:"text-sm sm:text-base font-medium"},"No Telepon",-1),Ke={class:"flex flex-col"},ze={key:1},He={class:"flex flex-col gap-2 mb-3"},Ge=e("label",{class:"text-sm sm:text-base font-medium"},"Password",-1),Je={class:"flex flex-col"},Qe={class:"flex flex-col gap-2 mb-3"},We=e("label",{class:"text-sm sm:text-base font-medium"},"Konfirmasi Password",-1),Xe={class:"flex flex-col"},Ye=["disabled"],Ze={key:0,class:"animate-spin h-7 w-7 mx-2",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},et=e("path",{class:"opacity-75",fill:"white",d:"M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"},null,-1),tt=[et],st={key:1},ot={class:"flex w-full justify-center text-center sm:text-base"},at=j({__name:"SignUp",setup(b){const t=w({}),s=w(),n=F(),o=w(!1),{data:c={}}=ne(),r=w(1),m=I().shape({name:g().required(),email:g().email("Invalid Email").required().label("Email"),phone:g().matches(/^08[0-9]\d{8,11}$/,"Invalid nomor telepon").required(),password:g().min(8,"Password minimal harus diisi 8 karakter").required().label("Password"),passwordConfirmation:g().oneOf([le("password")],"Passwords harus sesuai").required().label("Password Confirmation")});function p(){A(document.getElementById("form-register"));const d=new FormData;d.append("name",t.value.name),d.append("phone",t.value.phone),d.append("email",t.value.email),t.value?.password&&(d.append("password",t.value.password),d.append("password_confirmation",t.value.passwordConfirmation)),o.value=!0,U({method:"post",url:"auth/register",data:d,headers:{"Content-Type":"multipart/form-data"}}).then(()=>{S.success("Registrasi berhasil!"),s.value.resetForm(),n.push("/sign-in"),o.value=!1}).catch(l=>{S.error(l.response.data.message)}).finally(()=>{B(document.getElementById("form-register"))})}return(d,l)=>{const a=v("Field"),i=v("ErrorMessage"),k=v("router-link"),M=v("VForm");return h(),R(M,{"validation-schema":x(m),ref_key:"formRef",ref:s,id:"form-register",class:"w-full h-full min-h-screen flex justify-center bg-[#171717] items-center p-4"},{default:C(()=>[e("div",$e,[e("div",je,[Pe,e("i",qe,q(x(c)?.name),1)]),e("div",Oe,[u(te,{"enter-active-class":"transition duration-300 ease-out","enter-from-class":"transform opacity-0 translate-x-4","enter-to-class":"transform opacity-100 translate-x-0","leave-active-class":"transition duration-300 ease-in","leave-from-class":"transform opacity-100 translate-x-0","leave-to-class":"transform opacity-0 translate-x-4"},{default:C(()=>[r.value===1?(h(),y("div",Fe,[e("div",Ae,[Be,e("div",Ue,[u(a,{name:"name",type:"text",autocomplete:"off",modelValue:t.value.name,"onUpdate:modelValue":l[0]||(l[0]=f=>t.value.name=f),class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm",placeholder:"Masukkan Nama"},null,8,["modelValue"]),u(i,{name:"name",class:"text-red-500 text-xs sm:text-sm mt-1"})])]),e("div",Ie,[Ne,e("div",De,[u(a,{name:"email",type:"text",autocomplete:"off",modelValue:t.value.email,"onUpdate:modelValue":l[1]||(l[1]=f=>t.value.email=f),class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm",placeholder:"Masukkan Email"},null,8,["modelValue"]),u(i,{name:"email",class:"text-red-500 text-xs sm:text-sm mt-1"})])]),e("div",Le,[Te,e("div",Ke,[u(a,{name:"phone",type:"text",oninput:"this.value = this.value.replace(/[^\\d,]/g, '')",autocomplete:"off",modelValue:t.value.phone,"onUpdate:modelValue":l[2]||(l[2]=f=>t.value.phone=f),class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm",placeholder:"Masukkan No Telepon"},null,8,["modelValue"]),u(i,{name:"phone",class:"text-red-500 text-xs sm:text-sm mt-1"})])])])):_("",!0),r.value===2?(h(),y("div",ze,[e("div",He,[Ge,e("div",Je,[u(a,{name:"password",type:"password",autocomplete:"off",modelValue:t.value.password,"onUpdate:modelValue":l[3]||(l[3]=f=>t.value.password=f),class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm",placeholder:"Masukkan Password"},null,8,["modelValue"]),u(i,{name:"password",class:"text-red-500 text-xs sm:text-sm mt-1"})])]),e("div",Qe,[We,e("div",Xe,[u(a,{name:"passwordConfirmation",type:"password",autocomplete:"off",modelValue:t.value.passwordConfirmation,"onUpdate:modelValue":l[4]||(l[4]=f=>t.value.passwordConfirmation=f),class:"w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm",placeholder:"Masukkan Konfirmasi Password"},null,8,["modelValue"]),u(i,{name:"passwordConfirmation",class:"text-red-500 text-xs sm:text-sm mt-1"})])])])):_("",!0)]),_:1}),e("div",{class:V(["flex w-full",r.value===2?"justify-between":"justify-end"])},[e("button",{type:"button",class:"bg-cinema py-2.5 px-4 w-full sm:w-2/4 md:w-1/4 rounded-lg text-white font-semibold text-sm sm:text-sm",onClick:l[5]||(l[5]=f=>r.value=r.value===1?2:1)},q(r.value===1?"Next":"Previous"),1),se(e("button",{type:"submit",onClick:p,disabled:o.value,class:V([o.value?"flex p-2 justify-center":"block","bg-cinema py-2.5 px-4 w-full sm:w-2/4 md:w-1/4 rounded-lg text-white font-semibold text-sm sm:text-sm"])},[o.value?(h(),y("svg",Ze,tt)):_("",!0),o.value?_("",!0):(h(),y("span",st,"Register"))],10,Ye),[[oe,r.value===2]])],2),e("div",ot,[e("span",null,[E("Already have an account? "),u(k,{to:{name:"sign-in"},class:"text-cinema"},{default:C(()=>[E("Login Now")]),_:1})])])])])]),_:1},8,["validation-schema"])}}}),lt={class:"h-full w-full"},nt=e("img",{src:"/images/rows-red-seats-theater.jpg",class:"absolute md:pl-36 inset-0 w-full h-full object-cover saturate-50",alt:""},null,-1),rt={class:"sm:w-[43%] h-full text-white z-10 absolute left-0 items-center justify-center"},dt=j({__name:"Index",setup(b){const t=ae(),s=O(()=>t.path);return(n,o)=>(h(),y("div",lt,[nt,e("div",rt,[s.value==="/sign-in"?(h(),R(Se,{key:0})):_("",!0),s.value==="/sign-up"?(h(),R(at,{key:1})):_("",!0)])]))}});export{dt as default};
