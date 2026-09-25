/* ================= SPS-BMS: Core navigation & shared state ================= */
const pageLabels = {
  dashboard:'Dashboard', index:'Employees', 'employee-detail':'Employee Detail', profile:'My Profile', statement:'Statement',
  blog:'Employee Blog', 'form-a':'Form-A', 'form-b':'Form-B', plans:'Plans', performance:'Performance', demand:'Demand',
  timelive:'TimeLive', 'weekly-performance':'Weekly Performance', 'onboarding-checklist':'Onboarding Checklist',
  'onboarding-plan':'Onboarding Plan', 'onboarding-steps':'Onboarding Steps', 'orientation-plan':'Orientation Plan',
  'offboarding-checklist':'Offboarding Checklist', 'offboarding-plan':'Offboarding Plan'
};
let selectedEmployeeName = 'Abdul Hameed';
let currentLetter = null;

function currentEmployeeName(){ return selectedEmployeeName; }
function getEmployee(name=selectedEmployeeName){
  return employees.find(e=>e.name===name) || employees[0] || {
    id:null, name:'', type:'Employee', job:'', mgr:'', dept:'', group:'',
    practice:'—', loc:'', mobile:'', email:'', status:'Active', databaseData:{}
  };
}
function escapeHtml(value=''){ return String(value).replace(/[&<>'"]/g,ch=>({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[ch])); }

function goPage(name){
  const page=document.getElementById('page-'+name);
  if(!page){ showToast('This feature is not available.'); return; }
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  page.classList.add('active');
  document.querySelectorAll('.nav-item[data-page]').forEach(b=>b.classList.toggle('active', b.dataset.page===name));
  document.getElementById('crumbPage').textContent = pageLabels[name] || name;
  closeAllRowMenus(); closeSidebar(); syncEmployeeContext();
  if(name==='blog') renderBlogEntries();
  if(name==='performance') requestAnimationFrame(renderPerformanceCharts);
  if(name==='timelive') renderTimeLive();
  if(name==='weekly-performance') renderWeeklyPerformance();
  if(name==='onboarding-checklist') renderChecklist('onboardingChecklist');
  if(name==='onboarding-steps') renderChecklist('onboardingSteps');
  if(name==='offboarding-checklist') renderChecklist('offboardingChecklist');
  if(name==='onboarding-plan') renderOnboardingPlan();
  if(name==='offboarding-plan') renderOffboardingPlan();
  if(name==='orientation-plan') renderOrientationPlan();
  if(name==='form-a' || name==='form-b') loadSimpleForm(name==='form-a'?'formA':'formB');
  if(name==='employee-detail' && typeof renderEmployeeDetailAdvanced==='function') renderEmployeeDetailAdvanced();
  if(name==='plans' && typeof loadPlan==='function') loadPlan();
  window.scrollTo({top:0,behavior:'smooth'});
}
function openEmployeeFeature(name,page){ setSelectedEmployee(name); goPage(page); }
function setSelectedEmployee(name){ if(employees.some(e=>e.name===name)) selectedEmployeeName=name; syncEmployeeContext(); }
function syncEmployeeContext(){
  const e=getEmployee();
  document.querySelectorAll('[data-employee-name]').forEach(el=>el.textContent=e.name);
  document.querySelectorAll('[data-location-label]').forEach(el=>el.textContent=e.loc||'Global');
  document.querySelectorAll('.employee-name-input').forEach(el=>el.value=e.name);
  const aDept=document.getElementById('formADept'); if(aDept) aDept.value=e.dept||'';
  const aLoc=document.getElementById('formALoc'); if(aLoc) aLoc.value=e.loc||'';
}
function toggleWho(){ document.getElementById('whoMenu').classList.toggle('open'); }
document.addEventListener('click', e=>{
  if(!e.target.closest('.who')) document.getElementById('whoMenu')?.classList.remove('open');
  if(!e.target.closest('.action-menu')) closeAllRowMenus();
});
window.addEventListener('resize', closeAllRowMenus);

function toggleSidebar(){ document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sbOverlay').classList.toggle('show'); }
function closeSidebar(){ document.getElementById('sidebar').classList.remove('open'); document.getElementById('sbOverlay').classList.remove('show'); }

let toastTimer;
function showToast(msg){ const t=document.getElementById('toast'); if(!t) return; t.textContent=msg; t.classList.add('show'); clearTimeout(toastTimer); toastTimer=setTimeout(()=>t.classList.remove('show'),2600); }
function openModal(id){ const el=document.getElementById(id); if(el) el.classList.add('open'); }
function closeModal(id){ document.getElementById(id)?.classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(ov=>ov.addEventListener('click',e=>{if(e.target===ov)ov.classList.remove('open')}));
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.modal-overlay.open').forEach(o=>o.classList.remove('open'))});

function setDashTab(btn, which){
  document.querySelectorAll('.dash-tabs button').forEach(b=>b.classList.remove('active')); btn.classList.add('active');
  document.getElementById('dashRoles').style.display=which==='roles'?'grid':'none';
  document.getElementById('dashKpi').style.display=which==='kpi'?'block':'none';
  document.getElementById('dashPsp').style.display=which==='psp'?'block':'none';
}

/* ================= Employee index ================= */
// Employees are loaded from MySQL through api/employees/list.php.
let employees = [];

function actionItem(icon,label,handler,extra=''){ return `<button ${extra} onclick="${handler}"><span class="menu-icon">${icon}</span><span>${label}</span></button>`; }
function renderEmployees(list){
  const tb=document.getElementById('empTbody'); if(!tb) return; tb.innerHTML='';
  if(!list.length){ tb.innerHTML='<tr class="empty-row"><td colspan="12">No employees match your search.</td></tr>'; return; }
  list.forEach((e,i)=>{
    const safeName=e.name.replace(/'/g,"\\'");
    const statusBadge=e.status==='Active'?'<span class="badge badge-success">● Active</span>':'<span class="badge badge-danger">● Inactive</span>';
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><b>${escapeHtml(e.name)}</b></td><td>${escapeHtml(e.type)}</td><td>${escapeHtml(e.job)}</td><td>${escapeHtml(e.mgr||'—')}</td><td>${escapeHtml(e.dept)}</td><td>${escapeHtml(e.group)}</td><td>${escapeHtml(e.practice||'—')}</td><td>${escapeHtml(e.loc||'—')}</td><td class="mono" style="font-size:11.5px">${escapeHtml(e.mobile||'—')}</td><td><a href="#" onclick="return false" style="font-size:12px">${escapeHtml(e.email)}</a></td><td>${statusBadge}</td><td><div class="action-menu"><button class="dots" aria-label="Employee actions" onclick="toggleRowMenu(event,${i})">⋮</button><div class="dropdown employee-actions" id="rowmenu-${i}">
      ${actionItem('◫','Hours Distribution',`prepareHours('${safeName}')`)}
      ${actionItem('◉','HR Talk',`prepareHRTalk('${safeName}')`)}
      ${actionItem('◔','Blog',`openEmployeeFeature('${safeName}','blog')`)}
      ${actionItem('●','Dashboard',`setSelectedEmployee('${safeName}');goPage('dashboard')`)}
      ${actionItem('●','Profile',`setSelectedEmployee('${safeName}');goPage('profile')`)}
      <div class="menu-divider"></div>
      ${actionItem('⌘','Experience Certificate',`openLetter('experience','${safeName}')`)}
      ${actionItem('⌘','Role and Responsibility',`openLetter('role','${safeName}')`)}
      ${actionItem('⌘','Appointment Letter',`openLetter('appointment','${safeName}')`)}
      ${actionItem('◌','Form-A',`openEmployeeFeature('${safeName}','form-a')`)}
      ${actionItem('◌','Form-B',`openEmployeeFeature('${safeName}','form-b')`)}
      ${actionItem('◉','Certifications',`openCertifications('${safeName}')`)}
      ${actionItem('●',e.status,`toggleEmployeeStatus('${safeName}')`)}
      ${actionItem('▤','Statement',`setSelectedEmployee('${safeName}');goPage('statement')`)}
      ${actionItem('▣','Plans',`openEmployeeFeature('${safeName}','plans')`)}
      ${actionItem('↗','Performance',`openEmployeeFeature('${safeName}','performance')`)}
      ${actionItem('ⓘ','Demand',`openEmployeeFeature('${safeName}','demand')`)}
      ${actionItem('▤','TimeLive',`openEmployeeFeature('${safeName}','timelive')`)}
      ${actionItem('↗','Weekly Performance',`openEmployeeFeature('${safeName}','weekly-performance')`)}
      <div class="menu-subgroup"><button class="submenu-toggle" onclick="toggleActionSubmenu(event,this)"><span class="menu-icon">◫</span><span>Onboarding</span><span class="menu-chevron">›</span></button><div class="submenu-panel">${actionItem('✓','Checklist',`openEmployeeFeature('${safeName}','onboarding-checklist')`)}${actionItem('▣','Plan',`openEmployeeFeature('${safeName}','onboarding-plan')`)}${actionItem('→','Steps',`openEmployeeFeature('${safeName}','onboarding-steps')`)}${actionItem('◷','Orientation Plan',`openEmployeeFeature('${safeName}','orientation-plan')`)}</div></div>
      <div class="menu-subgroup"><button class="submenu-toggle" onclick="toggleActionSubmenu(event,this)"><span class="menu-icon">◫</span><span>Offboarding</span><span class="menu-chevron">›</span></button><div class="submenu-panel">${actionItem('✓','Checklist',`openEmployeeFeature('${safeName}','offboarding-checklist')`)}${actionItem('▣','Plan',`openEmployeeFeature('${safeName}','offboarding-plan')`)}${actionItem('◌','Reasons',`setSelectedEmployee('${safeName}');openOffboardingReasons()`)}</div></div>
      <div class="menu-divider"></div>${actionItem('👁','View Detail',`viewEmployee('${safeName}')`)}</div></div></td>`;
    tb.appendChild(tr);
  });
}
function toggleRowMenu(ev,i){
  ev.stopPropagation(); const menu=document.getElementById('rowmenu-'+i); const btn=ev.currentTarget; const opening=!menu.classList.contains('open'); closeAllRowMenus(); if(!opening)return;
  menu.classList.add('open'); menu.style.visibility='hidden'; menu.style.left='0px'; menu.style.top='0px';
  requestAnimationFrame(()=>{ const b=btn.getBoundingClientRect(), r=menu.getBoundingClientRect(); let left=Math.min(window.innerWidth-r.width-10,b.right-r.width); left=Math.max(10,left); let top=b.bottom+5; if(top+r.height>window.innerHeight-10) top=Math.max(10,b.top-r.height-5); menu.style.left=left+'px'; menu.style.top=top+'px'; menu.style.visibility='visible'; });
}
function toggleActionSubmenu(ev,btn){ ev.stopPropagation(); const panel=btn.nextElementSibling; panel.classList.toggle('open'); btn.classList.toggle('expanded',panel.classList.contains('open')); }
function closeAllRowMenus(){ document.querySelectorAll('.action-menu .dropdown').forEach(d=>{d.classList.remove('open');d.style.visibility='';d.querySelectorAll('.submenu-panel.open').forEach(p=>p.classList.remove('open'));}); }
async function toggleEmployeeStatus(name) {

  const employee = employees.find(
    item => item.name === name
  );

  if (!employee) {
    showToast("Employee not found.");
    return;
  }

  const newStatus =
    employee.status === "Active"
      ? "Inactive"
      : "Active";

  try {

    const response = await fetch(
      "api/employees/status.php",
      {
        method: "POST",

        headers: {
          "Content-Type": "application/json"
        },

        body: JSON.stringify({
          id: employee.id,
          status: newStatus
        })
      }
    );

    const result =
      await response.json();

    if (!result.success) {

      showToast(
        result.message ||
        "Could not update status."
      );

      return;
    }

    employee.status = newStatus;

    filterEmployees();

    showToast(
      `${employee.name} is now ${newStatus}.`
    );

  } catch (error) {

    console.error(
      "Status update error:",
      error
    );

    showToast(
      "Server error while updating status."
    );
  }
}

/* ================= Employee Detail ================= */
function setFieldValue(id,val){ const el=document.getElementById(id); if(!el)return; el.value=(val===undefined||val===null)?'':val; }
function guessEmailFromName(name){ return name?name.trim().toLowerCase().replace(/\s+/g,'.')+'@spsnet.com':''; }
function initialsFor(name){ const p=(name||'').trim().split(/\s+/); return ((p[0]?.[0]||'')+(p[1]?.[0]||'')).toUpperCase(); }
function openCertifications(name){ setSelectedEmployee(name); viewEmployee(name); setTimeout(()=>document.getElementById('certifications')?.scrollIntoView({behavior:'smooth',block:'start'}),120); }
/* ================= Hours Distribution ================= */
const hoursData=[
  {name:'Sales',groups:[{name:'Public Sector',leaves:['County Government','SLED-VA','SLED-MD','IAM-RFPs','Healthcare - Mid Atl','Government','Public Safety']},{name:'Energy',leaves:['Oil & Gas','Utilities']}]},
  {name:'Technical',groups:[{name:'Cloud',leaves:['DevOps','IAM','Automation']},{name:'Security',leaves:['Threat Management','Network Security']},{name:'AI',leaves:['Automation','Data Science']}]},
  {name:'Operations',groups:[{name:'Corporate',leaves:['Accounting','HR','Recruitment']},{name:'Administrative',leaves:['Facilities','Compliance']}]},
  {name:'Corporate',groups:[{name:'R & D',leaves:['Fabrico','Surgiverse']}]}
];
let hoursDistributionDb={};

async function prepareHours(name){
  setSelectedEmployee(name);
  closeAllRowMenus();

  hoursDistributionDb={};
  initHoursTree(hoursDistributionDb);
  openModal('modalHours');

  await loadHoursDistribution();
}

async function loadHoursDistribution(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/hours-distribution/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load hours distribution.');
    }

    hoursDistributionDb={};

    (result.data||[]).forEach(row=>{
      const key=`${row.department}|${row.group_name}|${row.practice}`;
      hoursDistributionDb[key]=row.hours;
    });

    initHoursTree(hoursDistributionDb);
    return true;

  }catch(error){
    console.error('Hours distribution load error:',error);
    showToast('Could not load hours distribution.');
    return false;
  }
}

function initHoursTree(saved=hoursDistributionDb){
  const root=document.getElementById('hoursTree');
  if(!root)return;

  root.innerHTML='<div class="hours-table-head"><span>Department / Group / Practice</span><span>Hours</span></div>';

  hoursData.forEach(dept=>{
    const l1=document.createElement('div');
    l1.className='tree-level1';

    const h1=document.createElement('div');
    h1.className='tree-h';
    h1.innerHTML=`<span>${escapeHtml(dept.name)}</span><span class="toggle" data-open="0">+</span>`;

    const body1=document.createElement('div');
    body1.className='collapsed';

    h1.onclick=()=>toggleTree(h1,body1);
    l1.appendChild(h1);

    dept.groups.forEach(grp=>{
      const l2=document.createElement('div');
      l2.className='tree-level2';

      const h2=document.createElement('div');
      h2.className='tree-h2';
      h2.innerHTML=`<span>${escapeHtml(grp.name)}</span><span class="toggle" data-open="0">+</span>`;

      const leaves=document.createElement('div');
      leaves.className='tree-leaves collapsed';

      h2.onclick=e=>{
        e.stopPropagation();
        toggleTree(h2,leaves);
      };

      l2.appendChild(h2);

      grp.leaves.forEach(leaf=>{
        const key=`${dept.name}|${grp.name}|${leaf}`;
        const row=document.createElement('div');
        row.className='tree-leaf';

        row.innerHTML=`
          <label>${escapeHtml(leaf)}</label>
          <input
            data-hour-key="${escapeHtml(key)}"
            type="number"
            min="0"
            step="0.5"
            value="${escapeHtml(saved[key]??'')}"
            placeholder="0"
            oninput="updateHoursTotal()"
          >
        `;

        leaves.appendChild(row);
      });

      l2.appendChild(leaves);
      body1.appendChild(l2);
    });

    l1.appendChild(body1);
    root.appendChild(l1);
  });

  updateHoursTotal();
}

function toggleTree(header,body){
  const open=header.querySelector('.toggle').dataset.open==='1';
  body.classList.toggle('collapsed',open);
  header.querySelector('.toggle').textContent=open?'+':'−';
  header.querySelector('.toggle').dataset.open=open?'0':'1';
}

function updateHoursTotal(){
  let total=0;

  document
    .querySelectorAll('#hoursTree [data-hour-key]')
    .forEach(input=>{
      total+=parseFloat(input.value)||0;
    });

  const totalElement=document.getElementById('hoursTotal');
  if(totalElement){
    totalElement.textContent=total.toFixed(1);
  }
}

async function saveHoursDistribution(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const records=[];

  document
    .querySelectorAll('#hoursTree [data-hour-key]')
    .forEach(input=>{
      const rawValue=input.value.trim();

      if(rawValue===''){
        return;
      }

      const [department,groupName,practice]=
        String(input.dataset.hourKey||'').split('|');

      const hours=parseFloat(rawValue)||0;

      if(!department||!groupName||!practice){
        return;
      }

      records.push({
        department,
        group_name:groupName,
        practice,
        hours
      });
    });

  try{
    const response=await fetch(
      'api/hours-distribution/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          records
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save hours distribution.');
      return false;
    }

    hoursDistributionDb={};

    records.forEach(row=>{
      if(Number(row.hours)>0){
        const key=`${row.department}|${row.group_name}|${row.practice}`;
        hoursDistributionDb[key]=row.hours;
      }
    });

    updateHoursTotal();
    closeModal('modalHours');
    showToast('Hours distribution saved successfully.');
    return true;

  }catch(error){
    console.error('Hours distribution save error:',error);
    showToast('Server error while saving hours distribution.');
    return false;
  }
}

/* ================= HR Talk ================= */
async function prepareHRTalk(name){
  setSelectedEmployee(name);
  closeAllRowMenus();

  const employee=getEmployee();

  const answerField=document.getElementById('hrTalkAnswer');
  const sendEmailField=document.getElementById('hrTalkSendEmail');

  if(answerField) answerField.value='';
  if(sendEmailField) sendEmailField.checked=false;

  openModal('modalHRTalk');

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return;
  }

  try{
    const response=await fetch(
      `api/hr-talk/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load HR Talk.');
    }

    const data=result.data;

    if(answerField){
      answerField.value=data?.answer||'';
    }

    if(sendEmailField){
      sendEmailField.checked=Number(data?.send_email||0)===1;
    }

  }catch(error){
    console.error('HR Talk load error:',error);
    showToast('Could not load HR Talk.');
  }
}
/* HR Talk save handler is defined in the database-backed feature layer below. */

/* ================= Blog editor ================= */
function editorCommand(cmd,value=null){ document.getElementById('blogEditor')?.focus(); document.execCommand(cmd,false,value); updateBlogWordCount(); }
function editorBlock(tag){ if(tag) editorCommand('formatBlock',tag); }
function insertEditorLink(){ const url=prompt('Enter URL'); if(url) editorCommand('createLink',url); }
function clearBlogEditor(){ const e=document.getElementById('blogEditor'); if(e)e.innerHTML=''; updateBlogWordCount(); }
function updateBlogWordCount(){ const e=document.getElementById('blogEditor'); const words=(e?.innerText.trim().match(/\S+/g)||[]).length; const c=document.getElementById('blogWordCount'); if(c)c.textContent=`${words} word${words===1?'':'s'}`; }
document.getElementById('blogEditor')?.addEventListener('input',updateBlogWordCount);
let employeeBlogEntries=[];

async function saveBlogEntry(){
  const employee=getEmployee();
  const editor=document.getElementById('blogEditor');

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  if(!editor){
    showToast('Blog editor not found.');
    return false;
  }

  const html=editor.innerHTML.trim();

  if(!editor.innerText.trim()){
    showToast('Write something before saving.');
    return false;
  }

  try{
    const response=await fetch(
      'api/blog/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          content:html
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save blog entry.');
      return false;
    }

    clearBlogEditor();
    await renderBlogEntries();
    showToast('Blog entry saved successfully.');
    return true;

  }catch(error){
    console.error('Blog save error:',error);
    showToast('Server error while saving blog entry.');
    return false;
  }
}

async function renderBlogEntries(){
  const wrap=document.getElementById('blogEntries');
  if(!wrap)return false;

  const employee=getEmployee();

  if(!employee||!employee.id){
    wrap.innerHTML='<div class="empty-state">Employee ID not found.</div>';
    return false;
  }

  wrap.innerHTML='<div class="empty-state">Loading blog entries...</div>';

  try{
    const response=await fetch(
      `api/blog/list.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load blog entries.');
    }

    employeeBlogEntries=Array.isArray(result.data)?result.data:[];

    wrap.innerHTML=employeeBlogEntries.length
      ? employeeBlogEntries.map(entry=>{
          const created=entry.created_at
            ? new Date(String(entry.created_at).replace(' ','T'))
            : null;

          const dateText=
            created && !Number.isNaN(created.getTime())
              ? created.toLocaleString()
              : escapeHtml(entry.created_at||'');

          return `
            <article class="timeline-item">
              <div class="timeline-dot"></div>
              <div>
                <div class="timeline-meta">${dateText}</div>
                <div class="timeline-content">${entry.content||''}</div>
                <button
                  class="text-action danger"
                  onclick="deleteBlogEntry(${Number(entry.id)})"
                >
                  Delete
                </button>
              </div>
            </article>
          `;
        }).join('')
      : '<div class="empty-state">No employee blog entries yet.</div>';

    return true;

  }catch(error){
    console.error('Blog load error:',error);
    employeeBlogEntries=[];
    wrap.innerHTML='<div class="empty-state">Could not load blog entries.</div>';
    return false;
  }
}

async function deleteBlogEntry(id){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  if(!id){
    showToast('Invalid blog entry.');
    return false;
  }

  try{
    const response=await fetch(
      'api/blog/delete.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          id:Number(id),
          employee_id:employee.id
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not delete blog entry.');
      return false;
    }

    await renderBlogEntries();
    showToast('Blog entry deleted successfully.');
    return true;

  }catch(error){
    console.error('Blog delete error:',error);
    showToast('Server error while deleting blog entry.');
    return false;
  }
}

/* ================= Letters / printable docs ================= */
const letterTemplates={
  experience:{title:'Experience Certificate',body:e=>`<p>To Whom It May Concern,</p><p>This is to certify that <b>${escapeHtml(e.name)}</b> has served with Software Productivity Strategists, Inc. as a valued ${escapeHtml(e.type.toLowerCase())} in the ${escapeHtml(e.dept)} department.</p><p>During the period of association, ${escapeHtml(e.name)} demonstrated professionalism, responsibility, and commitment to assigned duties. We wish them continued success in their professional career.</p>`},
  role:{title:'Role and Responsibility',body:e=>`<p><b>Employee:</b> ${escapeHtml(e.name)}</p><p><b>Department:</b> ${escapeHtml(e.dept)} &nbsp; <b>Group:</b> ${escapeHtml(e.group)}</p><p><b>Primary responsibilities</b></p><ul><li>Deliver assigned work in accordance with SPS quality standards.</li><li>Collaborate with managers, customers and cross-functional teams.</li><li>Maintain documentation, security and compliance requirements.</li><li>Support continuous improvement and knowledge sharing.</li></ul>`},
  appointment:{title:'Appointment Letter',body:e=>`<p>Dear <b>${escapeHtml(e.name)}</b>,</p><p>We are pleased to confirm your appointment with Software Productivity Strategists, Inc. within the <b>${escapeHtml(e.dept)}</b> department. Your reporting manager is <b>${escapeHtml(e.mgr||'to be assigned')}</b>.</p><p>Your employment is subject to company policies, applicable agreements and completion of required onboarding documentation.</p><p>Welcome to SPS.</p>`}
};
function openLetter(type,name){ setSelectedEmployee(name); const e=getEmployee(); const t=letterTemplates[type]; if(!t)return; currentLetter={type,title:t.title,employee:e.name,html:`<div class="letter-brand"><b>SPS-BMS</b><span>Software Productivity Strategists, Inc.</span></div><h2>${t.title}</h2><div class="letter-date">${new Date().toLocaleDateString()}</div>${t.body(e)}<p style="margin-top:40px">Authorized Signatory<br><b>Human Resources</b></p>`}; document.getElementById('letterModalTitle').textContent=t.title; document.getElementById('letterPreview').innerHTML=currentLetter.html; openModal('modalLetter'); closeAllRowMenus(); }
function downloadCurrentLetter(){ if(!currentLetter)return; const doc=`<!doctype html><html><head><meta charset="utf-8"><title>${currentLetter.title}</title><style>body{font-family:Arial,sans-serif;max-width:800px;margin:60px auto;line-height:1.7;color:#222}.letter-brand{display:flex;justify-content:space-between;border-bottom:2px solid #405189;padding-bottom:12px;color:#405189}h2{margin-top:45px}</style></head><body>${currentLetter.html}</body></html>`; const blob=new Blob([doc],{type:'text/html'}); const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=`${currentLetter.title.replace(/\s+/g,'-')}-${currentLetter.employee.replace(/\s+/g,'-')}.html`; a.click(); setTimeout(()=>URL.revokeObjectURL(a.href),500); }
function printCurrentLetter(){ if(!currentLetter)return; const w=window.open('','_blank','width=900,height=700'); w.document.write(`<html><head><title>${currentLetter.title}</title><style>body{font-family:Arial,sans-serif;max-width:800px;margin:60px auto;line-height:1.7}.letter-brand{display:flex;justify-content:space-between;border-bottom:2px solid #405189;padding-bottom:12px;color:#405189}</style></head><body>${currentLetter.html}</body></html>`); w.document.close(); w.focus(); w.print(); }

/* ================= Forms & plans ================= */
const employeeFormFields={
  formA:{
    type:'A',
    fields:{
      formAResponsibilities:'responsibilities',
      formANotes:'notes'
    }
  },
  formB:{
    type:'B',
    fields:{
      formBYear:'review_year',
      formBQuarter:'review_quarter',
      formBRating:'rating',
      formBAchievements:'achievements',
      formBDevelopment:'development'
    }
  }
};

function clearSimpleFormFields(kind){
  const config=employeeFormFields[kind];
  if(!config)return;
  Object.keys(config.fields).forEach(id=>setFieldValue(id,''));
}

async function loadSimpleForm(kind){
  const employee=getEmployee();
  const config=employeeFormFields[kind];

  if(!config){
    showToast('Invalid form type.');
    return false;
  }

  syncEmployeeContext();
  clearSimpleFormFields(kind);

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/forms/get.php?employee_id=${encodeURIComponent(employee.id)}&form_type=${encodeURIComponent(config.type)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load form.');
    }

    const data=result.data||{};

    Object.entries(config.fields).forEach(([elementId,columnName])=>{
      setFieldValue(elementId,data[columnName]??'');
    });

    return true;

  }catch(error){
    console.error(`${kind} load error:`,error);
    showToast(`Could not load ${kind==='formA'?'Form-A':'Form-B'}.`);
    return false;
  }
}

async function saveSimpleForm(kind){
  const employee=getEmployee();
  const config=employeeFormFields[kind];

  if(!config){
    showToast('Invalid form type.');
    return false;
  }

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const payload={
    employee_id:employee.id,
    form_type:config.type
  };

  Object.entries(config.fields).forEach(([elementId,columnName])=>{
    payload[columnName]=document.getElementById(elementId)?.value||'';
  });

  try{
    const response=await fetch(
      'api/forms/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save form.');
      return false;
    }

    showToast(`${kind==='formA'?'Form-A':'Form-B'} saved successfully.`);
    return true;

  }catch(error){
    console.error(`${kind} save error:`,error);
    showToast(`Server error while saving ${kind==='formA'?'Form-A':'Form-B'}.`);
    return false;
  }
}

async function resetStoredForm(kind){
  const employee=getEmployee();
  const config=employeeFormFields[kind];

  if(!config){
    showToast('Invalid form type.');
    return false;
  }

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const payload={
    employee_id:employee.id,
    form_type:config.type
  };

  Object.values(config.fields).forEach(columnName=>{
    payload[columnName]='';
  });

  try{
    const response=await fetch(
      'api/forms/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not reset form.');
      return false;
    }

    clearSimpleFormFields(kind);
    syncEmployeeContext();
    showToast(`${kind==='formA'?'Form-A':'Form-B'} reset successfully.`);
    return true;

  }catch(error){
    console.error(`${kind} reset error:`,error);
    showToast(`Server error while resetting ${kind==='formA'?'Form-A':'Form-B'}.`);
    return false;
  }
}

function togglePlanWorkspace(){ const w=document.getElementById('planWorkspace'); w.style.display=w.style.display==='none'?'block':'none'; }
async function savePlan(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const payload={
    employee_id:employee.id,
    goal:document.getElementById('planGoal')?.value||'',
    target_date:document.getElementById('planDate')?.value||'',
    progress:document.getElementById('planProgress')?.value||'',
    notes:document.getElementById('planNotes')?.value||''
  };

  try{
    const response=await fetch(
      'api/plans/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save development plan.');
      return false;
    }

    showToast('Development plan saved successfully.');
    return true;

  }catch(error){
    console.error('Development plan save error:',error);
    showToast('Server error while saving development plan.');
    return false;
  }
}

/* ================= Native lightweight charts ================= */
function drawMiniChart(canvas,values,label,type='line'){
  if(!canvas)return; const rect=canvas.getBoundingClientRect(); const ratio=window.devicePixelRatio||1; canvas.width=Math.max(500,rect.width*ratio); canvas.height=180*ratio; const ctx=canvas.getContext('2d'); ctx.scale(ratio,ratio); const w=canvas.width/ratio,h=canvas.height/ratio,p=28; ctx.clearRect(0,0,w,h); ctx.strokeStyle='#eef0f4'; ctx.lineWidth=1; for(let i=0;i<4;i++){const y=p+i*(h-2*p)/3;ctx.beginPath();ctx.moveTo(p,y);ctx.lineTo(w-p,y);ctx.stroke()} const max=Math.max(...values,1),min=Math.min(...values,0),range=max-min||1; ctx.strokeStyle='#405189';ctx.fillStyle='#405189';ctx.lineWidth=2; if(type==='bar'){const bw=(w-2*p)/values.length*.55;values.forEach((v,i)=>{const x=p+(i+.5)*(w-2*p)/values.length;const y=h-p-(v-min)/range*(h-2*p);ctx.fillRect(x-bw/2,y,bw,h-p-y)})}else{ctx.beginPath();values.forEach((v,i)=>{const x=p+i*(w-2*p)/(values.length-1);const y=h-p-(v-min)/range*(h-2*p);if(i===0)ctx.moveTo(x,y);else ctx.lineTo(x,y)});ctx.stroke();values.forEach((v,i)=>{const x=p+i*(w-2*p)/(values.length-1),y=h-p-(v-min)/range*(h-2*p);ctx.beginPath();ctx.arc(x,y,3,0,Math.PI*2);ctx.fill()})} ctx.fillStyle='#74788d';ctx.font='11px Public Sans, sans-serif';ctx.fillText(label,p,16); }
let performanceState=null;

function defaultPerformanceState(year){
  return{
    year,
    revenue_margin:[],
    utilization:[],
    certifications:[],
    communication_score:[],
    performance_choice:'',
    performance_dimension:''
  };
}

function validPerformanceSeries(value,fallback){
  if(
    Array.isArray(value) &&
    value.length
  ){
    return value.map(item=>{
      const number=Number(item);
      return Number.isFinite(number)
        ? number
        : 0;
    });
  }

  return [...fallback];
}

function applyPerformanceSelections(){
  const page=document.getElementById('page-performance');
  if(!page||!performanceState)return;

  const choice=performanceState.performance_choice||'';

  if(choice){
    const choiceButtons=[
      ...page.querySelectorAll(
        'button[onclick*="selectChoice"]'
      )
    ];

    const matchingChoice=
      choiceButtons.find(
        button=>button.innerText.trim()===choice
      );

    if(matchingChoice){
      matchingChoice
        .parentElement
        ?.querySelectorAll('button')
        .forEach(
          button=>button.classList.remove('selected')
        );

      matchingChoice.classList.add('selected');
    }
  }

  const dimension=
    performanceState.performance_dimension||'';

  if(dimension){
    const dimensionButtons=[
      ...page.querySelectorAll(
        'button[onclick*="selectDimension"]'
      )
    ];

    const matchingDimension=
      dimensionButtons.find(button=>{
        const title=
          button.querySelector('b')
            ?.textContent
            ?.trim()
            ?.toLowerCase()||'';

        return title===dimension.toLowerCase();
      });

    dimensionButtons.forEach(
      button=>button.classList.remove('selected')
    );

    if(matchingDimension){
      matchingDimension.classList.add('selected');
    }
  }
}

function drawPerformanceState(){
  if(!performanceState)return;

  drawMiniChart(
    document.getElementById('chartRevenue'),
    performanceState.revenue_margin,
    'Revenue / Margin',
    'bar'
  );

  drawMiniChart(
    document.getElementById('chartUtilization'),
    performanceState.utilization,
    'Utilization %'
  );

  drawMiniChart(
    document.getElementById('chartCerts'),
    performanceState.certifications,
    'Certifications',
    'bar'
  );

  drawMiniChart(
    document.getElementById('chartCommunication'),
    performanceState.communication_score,
    'Communication score'
  );
}

async function savePerformanceData({silent=false}={}){
  const employee=getEmployee();
  const year=Number(
    document.getElementById('performanceYear')?.value ||
    performanceState?.year ||
    2026
  );

  if(!employee||!employee.id){
    if(!silent){
      showToast('Employee ID not found.');
    }
    return false;
  }

  if(
    !performanceState ||
    Number(performanceState.year)!==year
  ){
    performanceState=defaultPerformanceState(year);
  }

  const payload={
    employee_id:employee.id,
    performance_year:year,
    revenue_margin:
      performanceState.revenue_margin,
    utilization:
      performanceState.utilization,
    certifications:
      performanceState.certifications,
    communication_score:
      performanceState.communication_score,
    performance_choice:
      performanceState.performance_choice||'',
    performance_dimension:
      performanceState.performance_dimension||''
  };

  try{
    const response=await fetch(
      'api/performance/save.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      if(!silent){
        showToast(
          result.message||
          'Could not save performance.'
        );
      }
      return false;
    }

    if(!silent){
      showToast('Performance saved successfully.');
    }

    return true;

  }catch(error){
    console.error(
      'Performance save error:',
      error
    );

    if(!silent){
      showToast(
        'Server error while saving performance.'
      );
    }

    return false;
  }
}

async function loadPerformanceData(year){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    performanceState=defaultPerformanceState(year);
    drawPerformanceState();
    return false;
  }

  const defaults=
    defaultPerformanceState(year);

  try{
    const response=await fetch(
      `api/performance/get.php?employee_id=${encodeURIComponent(employee.id)}&year=${encodeURIComponent(year)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(
        result.message||
        'Could not load performance.'
      );
    }

    const data=result.data;

    if(data){
      performanceState={
        year,
        revenue_margin:
          validPerformanceSeries(
            data.revenue_margin,
            defaults.revenue_margin
          ),
        utilization:
          validPerformanceSeries(
            data.utilization,
            defaults.utilization
          ),
        certifications:
          validPerformanceSeries(
            data.certifications,
            defaults.certifications
          ),
        communication_score:
          validPerformanceSeries(
            data.communication_score,
            defaults.communication_score
          ),
        performance_choice:
          data.performance_choice||'',
        performance_dimension:
          data.performance_dimension||''
      };
    }else{
      performanceState=defaults;
    }

    drawPerformanceState();
    applyPerformanceSelections();
    return true;

  }catch(error){
    console.error(
      'Performance load error:',
      error
    );

    performanceState=defaults;
    drawPerformanceState();

    showToast('Could not load performance.');
    return false;
  }
}

async function renderPerformanceCharts(){
  const year=Number(
    document.getElementById('performanceYear')?.value||
    2026
  );

  return loadPerformanceData(year);
}

async function selectChoice(btn){
  if(!btn)return false;

  const year=Number(
    document.getElementById('performanceYear')?.value||
    2026
  );

  if(
    !performanceState ||
    Number(performanceState.year)!==year
  ){
    await loadPerformanceData(year);
  }

  const parent=btn.parentElement;

  parent
    ?.querySelectorAll('button')
    .forEach(
      button=>button.classList.remove('selected')
    );

  btn.classList.add('selected');

  performanceState.performance_choice=
    btn.innerText.trim();

  return savePerformanceData();
}

/* ================= TimeLive & weekly performance ================= */
let timeLiveRows=[];
let timeLiveLoadedEmployeeId=null;

function renderTimeLiveTable(){
  const body=document.getElementById('timeLiveBody');
  if(!body)return;

  const start=document.getElementById('tlStart')?.value||'';
  const end=document.getElementById('tlEnd')?.value||'';
  const q=(document.getElementById('tlSearch')?.value||'')
    .trim()
    .toLowerCase();

  const requestedSize=Number(
    document.getElementById('tlPageSize')?.value||10
  );

  const pageSize=
    Number.isFinite(requestedSize) && requestedSize>0
      ? requestedSize
      : 10;

  const filtered=timeLiveRows.filter(row=>{
    const haystack=[
      row.date,
      row.client,
      row.project,
      row.task,
      row.desc,
      row.hours
    ].join(' ').toLowerCase();

    return(
      (!start||row.date>=start) &&
      (!end||row.date<=end) &&
      (!q||haystack.includes(q))
    );
  });

  const rows=filtered.slice(0,pageSize);

  body.innerHTML=rows.length
    ? rows.map((row,index)=>`
        <tr>
          <td>${index+1}</td>
          <td>${escapeHtml(row.date||'')}</td>
          <td>${escapeHtml(row.client||'')}</td>
          <td>${escapeHtml(row.project||'')}</td>
          <td>${escapeHtml(row.task||'')}</td>
          <td>${escapeHtml(row.desc||'')}</td>
          <td class="mono">${Number(row.hours||0).toFixed(1)}</td>
        </tr>
      `).join('')
    : '<tr class="empty-row"><td colspan="7">No data available in table</td></tr>';

  const summary=document.getElementById('timeLiveSummary');

  if(summary){
    const shownHours=rows.reduce(
      (sum,row)=>sum+Number(row.hours||0),
      0
    );

    summary.textContent=
      `Showing ${rows.length} entr${rows.length===1?'y':'ies'} · ${shownHours.toFixed(1)} hours`;
  }
}

async function loadTimeLiveFromDatabase(force=false){
  const employee=getEmployee();

  if(!employee||!employee.id){
    timeLiveRows=[];
    timeLiveLoadedEmployeeId=null;
    renderTimeLiveTable();
    showToast('Employee ID not found.');
    return false;
  }

  const employeeId=Number(employee.id);

  if(
    !force &&
    timeLiveLoadedEmployeeId===employeeId
  ){
    return true;
  }

  const body=document.getElementById('timeLiveBody');

  if(body){
    body.innerHTML=
      '<tr class="empty-row"><td colspan="7">Loading TimeLive data...</td></tr>';
  }

  try{
    const response=await fetch(
      `api/timelive/list.php?employee_id=${encodeURIComponent(employeeId)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(
        result.message||
        'Could not load TimeLive data.'
      );
    }

    timeLiveRows=(result.data||[]).map(row=>({
      id:Number(row.id)||0,
      date:row.work_date||'',
      client:row.client||'',
      project:row.project||'',
      task:row.task||'',
      desc:row.description||'',
      hours:Number(row.hours)||0
    }));

    timeLiveLoadedEmployeeId=employeeId;
    return true;

  }catch(error){
    console.error(
      'TimeLive load error:',
      error
    );

    timeLiveRows=[];
    timeLiveLoadedEmployeeId=employeeId;

    showToast('Could not load TimeLive data.');
    return false;
  }
}

async function renderTimeLive(){
  await loadTimeLiveFromDatabase(false);
  renderTimeLiveTable();
}

async function refreshTimeLive(){
  await loadTimeLiveFromDatabase(true);
  renderTimeLiveTable();
}

async function saveTimeLiveEntry(entry={}){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const payload={
    id:Number(entry.id)||0,
    employee_id:Number(employee.id),
    work_date:entry.work_date||entry.date||'',
    client:entry.client||'',
    project:entry.project||'',
    task:entry.task||'',
    description:entry.description||entry.desc||'',
    hours:Number(entry.hours)||0
  };

  try{
    const response=await fetch(
      'api/timelive/save.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(
        result.message||
        'Could not save TimeLive entry.'
      );
      return false;
    }

    await refreshTimeLive();
    showToast('TimeLive entry saved successfully.');
    return true;

  }catch(error){
    console.error(
      'TimeLive save error:',
      error
    );

    showToast(
      'Server error while saving TimeLive entry.'
    );

    return false;
  }
}

async function deleteTimeLiveEntry(id){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  if(!Number(id)){
    showToast('Invalid TimeLive entry.');
    return false;
  }

  try{
    const response=await fetch(
      'api/timelive/delete.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify({
          id:Number(id),
          employee_id:Number(employee.id)
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(
        result.message||
        'Could not delete TimeLive entry.'
      );
      return false;
    }

    await refreshTimeLive();
    showToast('TimeLive entry deleted successfully.');
    return true;

  }catch(error){
    console.error(
      'TimeLive delete error:',
      error
    );

    showToast(
      'Server error while deleting TimeLive entry.'
    );

    return false;
  }
}
const WEEKLY_PERFORMANCE_YEAR=2026;

let weeklyPerformanceRows=[];
let weeklyPerformanceLoadedEmployeeId=null;
let weeklyPerformanceLoadedYear=null;

function weeklyPerformanceStatus(score){
  const value=Number(score)||0;

  if(value>=90){
    return{
      label:'Excellent',
      className:'badge-success'
    };
  }

  if(value>=80){
    return{
      label:'On Track',
      className:'badge-info'
    };
  }

  return{
    label:'Watch',
    className:'badge-accent'
  };
}

function renderWeeklyPerformanceRows(){
  const root=document.getElementById('weeklyRows');
  if(!root)return;

  if(!weeklyPerformanceRows.length){
    root.innerHTML=`
      <div class="weekly-row">
        <span>No weekly performance data available.</span>
      </div>
    `;
    return;
  }

  root.innerHTML=weeklyPerformanceRows
    .map(row=>{
      const week=Number(row.week_number)||0;
      const score=Math.max(
        0,
        Math.min(
          100,
          Number(row.score)||0
        )
      );

      const status=
        weeklyPerformanceStatus(score);

      return`
        <div class="weekly-row">
          <span>Week ${week}</span>

          <div class="progress-track">
            <i style="width:${score}%"></i>
          </div>

          <b>${score.toFixed(
            Number.isInteger(score)
              ? 0
              : 1
          )}%</b>

          <span class="badge ${status.className}">
            ${status.label}
          </span>
        </div>
      `;
    })
    .join('');
}

async function loadWeeklyPerformance(
  year=WEEKLY_PERFORMANCE_YEAR,
  force=false
){
  const employee=getEmployee();

  if(!employee||!employee.id){
    weeklyPerformanceRows=[];
    weeklyPerformanceLoadedEmployeeId=null;
    weeklyPerformanceLoadedYear=null;
    renderWeeklyPerformanceRows();
    showToast('Employee ID not found.');
    return false;
  }

  const employeeId=Number(employee.id);
  const selectedYear=Number(year)||WEEKLY_PERFORMANCE_YEAR;

  if(
    !force &&
    weeklyPerformanceLoadedEmployeeId===employeeId &&
    weeklyPerformanceLoadedYear===selectedYear
  ){
    return true;
  }

  const root=document.getElementById('weeklyRows');

  if(root){
    root.innerHTML=`
      <div class="weekly-row">
        <span>Loading weekly performance...</span>
      </div>
    `;
  }

  try{
    const response=await fetch(
      `api/weekly-performance/list.php?employee_id=${encodeURIComponent(employeeId)}&year=${encodeURIComponent(selectedYear)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(
        result.message||
        'Could not load weekly performance.'
      );
    }

    weeklyPerformanceRows=(result.data||[])
      .map(row=>({
        id:Number(row.id)||0,
        employee_id:
          Number(row.employee_id)||employeeId,
        performance_year:
          Number(row.performance_year)||selectedYear,
        week_number:
          Number(row.week_number)||0,
        score:Number(row.score)||0
      }))
      .filter(row=>row.week_number>0)
      .sort(
        (a,b)=>
          a.week_number-b.week_number
      );

    weeklyPerformanceLoadedEmployeeId=employeeId;
    weeklyPerformanceLoadedYear=selectedYear;

    return true;

  }catch(error){
    console.error(
      'Weekly performance load error:',
      error
    );

    weeklyPerformanceRows=[];
    weeklyPerformanceLoadedEmployeeId=employeeId;
    weeklyPerformanceLoadedYear=selectedYear;

    showToast(
      'Could not load weekly performance.'
    );

    return false;
  }
}

async function renderWeeklyPerformance(
  year=WEEKLY_PERFORMANCE_YEAR
){
  await loadWeeklyPerformance(year,false);
  renderWeeklyPerformanceRows();
}

async function refreshWeeklyPerformance(
  year=WEEKLY_PERFORMANCE_YEAR
){
  await loadWeeklyPerformance(year,true);
  renderWeeklyPerformanceRows();
}

async function saveWeeklyPerformanceEntry(
  weekNumber,
  score,
  year=WEEKLY_PERFORMANCE_YEAR
){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const week=Number(weekNumber);
  const numericScore=Number(score);
  const selectedYear=
    Number(year)||WEEKLY_PERFORMANCE_YEAR;

  if(!Number.isInteger(week)||week<=0){
    showToast('Week number must be greater than 0.');
    return false;
  }

  if(
    !Number.isFinite(numericScore) ||
    numericScore<0 ||
    numericScore>100
  ){
    showToast('Score must be between 0 and 100.');
    return false;
  }

  try{
    const response=await fetch(
      'api/weekly-performance/save.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify({
          employee_id:Number(employee.id),
          performance_year:selectedYear,
          week_number:week,
          score:numericScore
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(
        result.message||
        'Could not save weekly performance.'
      );
      return false;
    }

    await refreshWeeklyPerformance(selectedYear);

    showToast(
      'Weekly performance saved successfully.'
    );

    return true;

  }catch(error){
    console.error(
      'Weekly performance save error:',
      error
    );

    showToast(
      'Server error while saving weekly performance.'
    );

    return false;
  }
}

async function deleteWeeklyPerformanceEntry(
  id,
  year=WEEKLY_PERFORMANCE_YEAR
){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const recordId=Number(id);

  if(!recordId){
    showToast(
      'Invalid weekly performance record.'
    );
    return false;
  }

  try{
    const response=await fetch(
      'api/weekly-performance/delete.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify({
          id:recordId,
          employee_id:Number(employee.id)
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(
        result.message||
        'Could not delete weekly performance.'
      );
      return false;
    }

    await refreshWeeklyPerformance(year);

    showToast(
      'Weekly performance deleted successfully.'
    );

    return true;

  }catch(error){
    console.error(
      'Weekly performance delete error:',
      error
    );

    showToast(
      'Server error while deleting weekly performance.'
    );

    return false;
  }
}

/* ================= Checklists ================= */
const onboardingChecklistSections=[
  {title:'Employee Documents',items:['Resume','Offer Letter','Job Description','SPS Employee Service Agreement','Employee Confidential and Proprietary Information and Non Disclosure Agreement','Background check Consent Letter','Personal Information Form','Emergency Contact Form','Direct Deposit Form','Employees Latest Degree, Photographs and copy of CNIC','Experience letter','Email Configuration request to help desk','Time - Live configuration request to Accounting','BMS Email Configuration request to BMS-Dev','Reference Check Report']},
  {title:'Orientation',items:['Email accounting for Time-Live Orientation','Email IT department for IT orientation','101 - SPS Overview','110 - Working at SPS - Part One','120 - Working at SPS - Part Two','130 - Working at SPS - Part Three','130 01 - Guidelines to Social Computing','140 - Succeeding at SPS','BMS Orientation','Send SPS Orientation Feedback form']},
  {title:'Administrative',items:['Welcome to SPS Travel Email to PKFT','Set up in TimeLive system','Getting Started with SPS Email to Employee','Asset Management form','Office Key Assigned (if applicable)','Desk Key (if applicable)','Access Card Assigned','Background Check report','Payroll Information Form','SPS Corporate Credit Card','Add in PKFT, PKPT groups','Add in SharePoint','Add in IBM Partner World','Send On boarding Feedback form','Update Employee data on HR server','Files']}
];
const onboardingSteps=['Write a Detailed Job Description','Craft a Compelling Job Offer','Create a Pre-Boarding Process','Make a Good First Impression','Establish Your Organization’ Culture and Values','Introduce Your New Hire to the Team','Plan a Training Schedule','Set Expectations Around the Role and Performance','Provide Ongoing Support and Feedback','Re-Board When Necessary'];
const offboardingItems=['Disable Email','Disable user from Directory Server','Remove all the Group Memberships','Hardware handing taking over','Biometric attendance user removal','Disable CSM Account','Disable BMS Account','Update DHCP Server','Data Backup','Disable IBM Cloud Account','Disable FTP Account'];
function checklistConfig(kind){
  if(kind==='onboardingChecklist'){
    return{
      body:'onboardingChecklistBody',
      mode:'applicable',
      apiType:'onboarding_checklist',
      sections:onboardingChecklistSections
    };
  }

  if(kind==='onboardingSteps'){
    return{
      body:'onboardingStepsBody',
      mode:'applied',
      apiType:'onboarding_steps',
      sections:[{title:'',items:onboardingSteps}]
    };
  }

  return{
    body:'offboardingChecklistBody',
    mode:'ynna',
    apiType:'offboarding_checklist',
    sections:[{title:'',items:offboardingItems}]
  };
}

function buildChecklistSavedMap(rows=[]){
  const saved={};

  rows.forEach(row=>{
    if(!row?.item_key)return;

    saved[row.item_key]={
      choice:row.choice_value||'',
      note:row.note||''
    };
  });

  return saved;
}

function renderChecklistRows(kind,saved={}){
  const cfg=checklistConfig(kind);
  const body=document.getElementById(cfg.body);

  if(!body)return;

  let n=0;
  let html='';

  cfg.sections.forEach(sec=>{
    if(sec.title){
      html+=`<tr class="section-row"><td colspan="5">${escapeHtml(sec.title)}</td></tr>`;
    }

    sec.items.forEach(item=>{
      n++;

      const id=`${kind}-${n}`;
      const value=saved[id]||{};

      if(cfg.mode==='ynna'){
        html+=`
          <tr>
            <td>${escapeHtml(item)}</td>
            <td><input type="radio" name="${id}" value="yes" ${value.choice==='yes'?'checked':''}></td>
            <td><input type="radio" name="${id}" value="no" ${value.choice==='no'?'checked':''}></td>
            <td><input type="radio" name="${id}" value="na" ${value.choice==='na'?'checked':''}></td>
            <td><textarea data-note="${id}" rows="2">${escapeHtml(value.note||'')}</textarea></td>
          </tr>
        `;
      }else{
        html+=`
          <tr>
            <td>${n}</td>
            <td>${escapeHtml(item)}</td>
            <td><input type="radio" name="${id}" value="yes" ${value.choice==='yes'?'checked':''}></td>
            <td><input type="radio" name="${id}" value="no" ${value.choice==='no'?'checked':''}></td>
            <td><textarea data-note="${id}" rows="2">${escapeHtml(value.note||'')}</textarea></td>
          </tr>
        `;
      }
    });
  });

  body.innerHTML=html;
}

async function renderChecklist(kind){
  const employee=getEmployee();
  const cfg=checklistConfig(kind);
  const body=document.getElementById(cfg.body);

  if(!body)return false;

  renderChecklistRows(kind,{});

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/checklists/get.php?employee_id=${encodeURIComponent(employee.id)}&checklist_type=${encodeURIComponent(cfg.apiType)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load checklist.');
    }

    renderChecklistRows(
      kind,
      buildChecklistSavedMap(result.data||[])
    );

    return true;

  }catch(error){
    console.error(`${kind} load error:`,error);
    showToast('Could not load checklist.');
    return false;
  }
}

async function saveChecklist(kind){
  const employee=getEmployee();
  const cfg=checklistConfig(kind);
  const body=document.getElementById(cfg.body);

  if(!body)return false;

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const labels={};
  let n=0;

  cfg.sections.forEach(sec=>{
    sec.items.forEach(item=>{
      n++;
      labels[`${kind}-${n}`]=item;
    });
  });

  const records=[];

  body.querySelectorAll('textarea[data-note]').forEach(textarea=>{
    const itemKey=textarea.dataset.note;
    const choice=
      body.querySelector(`input[name="${itemKey}"]:checked`)?.value||'';

    records.push({
      item_key:itemKey,
      item_label:labels[itemKey]||'',
      choice_value:choice,
      note:textarea.value||''
    });
  });

  try{
    const response=await fetch(
      'api/checklists/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          checklist_type:cfg.apiType,
          records
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save checklist.');
      return false;
    }

    showToast('Checklist saved successfully.');
    return true;

  }catch(error){
    console.error(`${kind} save error:`,error);
    showToast('Server error while saving checklist.');
    return false;
  }
}

function setChecklistScope(scope){ showToast(`${scope} checklist view selected.`); }

/* ================= Onboarding / offboarding plans ================= */
const onboardingPlanRows=[
 ['Recruitment / Pre-Onboarding','Role Enablement','1. Hiring manager creates a role and responsibilities in BMS.\n2. Create a job and complete the requisition.','Hasnain Zahid'],['Recruitment / Pre-Onboarding','Job Analysis','Send position to HR; publish on LinkedIn, Indeed and company website.','Hasnain Zahid'],['Recruitment / Pre-Onboarding','Resume Screening + Phone Screening','HR screens candidates and shares the report with the hiring manager.','Hasnain Zahid'],['Recruitment / Pre-Onboarding','Technical Interview','Hiring manager shortlists candidates for technical interview.','Select Employee'],['Recruitment / Pre-Onboarding','Final Interview','Hiring manager and HR conduct final interview.','Select Employee'],['Recruitment / Pre-Onboarding','Offer Letter','HR prepares and sends offer letter.','Hasnain Zahid'],['Onboarding','Draft Official Documents','Prepare NDA, Consent Letter and SPS Agreement.','Hasnain Zahid'],['Onboarding','Email to SPS IT','Configure official email address and device.','Hasnain Zahid'],['Onboarding','Email Accounting for TimeLive','Accounting configures TimeLive.','Hasnain Zahid'],['Onboarding','BMS Enablement','Create BMS account and credentials.','Hasnain Zahid'],['Orientation','HR Orientation','Welcome to SPS, Org Chart, Website Overview, Policies and Benefits, Learning & Development.','Hasnain Zahid'],['Orientation','IT Orientation','Device access, Office 365, Teams, Helpdesk.','Talha Kaleem'],['Orientation','Accounting Orientation','Compensation, benefits, job codes, TimeLive and expenses.','Select Employee'],['Post Onboarding','15 Days Performance Review','HR and hiring manager complete first review.','Select Employee'],['Post Onboarding','One Month Performance Review','HR and hiring manager complete one-month review.','Select Employee']
];
const offboardingPlanRows=[['Offboarding - Voluntary Termination','Resignation from Employee','Select Employee'],['Offboarding - Voluntary Termination','Completion of Notice Period','Select Employee'],['Offboarding - Voluntary Termination','Offboarding - Voluntary Termination','Select Employee'],['Offboarding - Voluntary Termination','Email to IT — ID deconfiguration, disable IT assets, remove groups, deactivate servers and drive access, IT clearance','Select Employee'],['Offboarding - Voluntary Termination','Email to Accounting — deactivate TimeLive, check insurance/PTO/loan, accounting clearance','Hasnain Zahid'],['Offboarding - Voluntary Termination','Email to BMS — deactivate BMS account, remove employee from org chart, update reason for leaving','Select Employee'],['Offboarding - Voluntary Termination','Partner Portal — remove employee from partner portals','Select Employee'],['Offboarding - Voluntary Termination','Final Documentation — official documents, exit interview, HR server update','Select Employee']];
const assigneeOptions=['Select Employee','Hasnain Zahid','Talha Kaleem','Maryam Toor','Hash Malik'];

const planAssignmentCache={
  onboarding:{},
  offboarding:{}
};

function assigneeSelect(value,key){
  return `
    <select onchange="saveAssignee('${key}',this.value)">
      ${assigneeOptions
        .map(option=>`
          <option value="${escapeHtml(option)}" ${option===value?'selected':''}>
            ${escapeHtml(option)}
          </option>
        `)
        .join('')}
    </select>
  `;
}

function planAssignmentMeta(key){
  const value=String(key||'');

  if(value.startsWith('on-')){
    const index=Number(value.slice(3));

    if(Number.isInteger(index) && onboardingPlanRows[index]){
      return{
        planType:'onboarding',
        index,
        taskName:onboardingPlanRows[index][1]
      };
    }
  }

  if(value.startsWith('off-')){
    const index=Number(value.slice(4));

    if(Number.isInteger(index) && offboardingPlanRows[index]){
      return{
        planType:'offboarding',
        index,
        taskName:offboardingPlanRows[index][1]
      };
    }
  }

  return null;
}

async function saveAssignee(key,value){
  const employee=getEmployee();
  const meta=planAssignmentMeta(key);

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  if(!meta){
    showToast('Invalid plan assignment.');
    return false;
  }

  try{
    const response=await fetch(
      'api/plan-assignments/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          plan_type:meta.planType,
          item_key:key,
          task_name:meta.taskName,
          assignee:value
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save responsible party.');
      return false;
    }

    planAssignmentCache[meta.planType][key]=value;
    showToast('Responsible party updated.');
    return true;

  }catch(error){
    console.error('Plan assignment save error:',error);
    showToast('Server error while saving responsible party.');
    return false;
  }
}

function renderOnboardingPlanRows(saved={}){
  const body=document.getElementById('onboardingPlanBody');

  if(!body)return;

  let previousModule='';

  body.innerHTML=onboardingPlanRows.map((row,index)=>{
    const moduleCell=
      row[0]!==previousModule
        ? `<td class="module-cell">${escapeHtml(row[0])}</td>`
        : '<td class="module-cell muted">↳</td>';

    previousModule=row[0];

    const key=`on-${index}`;
    const assignee=saved[key]||row[3];

    return `
      <tr class="${row[0]==='Recruitment / Pre-Onboarding'?'phase-green':'phase-peach'}">
        <td>${index+1}</td>
        ${moduleCell}
        <td>
          <b>${escapeHtml(row[1])}</b>
          <div class="row-actions">✎ + ▢</div>
        </td>
        <td class="preline">${escapeHtml(row[2])}</td>
        <td>${assigneeSelect(assignee,key)}</td>
      </tr>
    `;
  }).join('');
}

async function renderOnboardingPlan(){
  const employee=getEmployee();
  const body=document.getElementById('onboardingPlanBody');

  if(!body)return false;

  planAssignmentCache.onboarding={};
  renderOnboardingPlanRows(planAssignmentCache.onboarding);

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/plan-assignments/get.php?employee_id=${encodeURIComponent(employee.id)}&plan_type=onboarding`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load onboarding plan assignments.');
    }

    planAssignmentCache.onboarding={};

    (result.data||[]).forEach(row=>{
      if(row.item_key){
        planAssignmentCache.onboarding[row.item_key]=row.assignee||'Select Employee';
      }
    });

    renderOnboardingPlanRows(planAssignmentCache.onboarding);
    return true;

  }catch(error){
    console.error('Onboarding plan assignment load error:',error);
    showToast('Could not load onboarding plan assignments.');
    return false;
  }
}

function renderOffboardingPlanRows(saved={}){
  const body=document.getElementById('offboardingPlanBody');

  if(!body)return;

  body.innerHTML=offboardingPlanRows.map((row,index)=>{
    const key=`off-${index}`;
    const assignee=saved[key]||row[2];
    const titleParts=row[1].split(' — ');

    return `
      <tr class="phase-green">
        <td>${index+1}</td>
        <td class="module-cell">${index===0?escapeHtml(row[0]):'↳'}</td>
        <td class="preline">
          <b>${escapeHtml(titleParts[0])}</b>
          ${titleParts.length>1?'<br>'+escapeHtml(titleParts.slice(1).join(' — ')):''}
          <div class="row-actions">✎ ▢</div>
        </td>
        <td>${assigneeSelect(assignee,key)}</td>
      </tr>
    `;
  }).join('');
}

async function renderOffboardingPlan(){
  const employee=getEmployee();
  const body=document.getElementById('offboardingPlanBody');

  if(!body)return false;

  planAssignmentCache.offboarding={};
  renderOffboardingPlanRows(planAssignmentCache.offboarding);

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/plan-assignments/get.php?employee_id=${encodeURIComponent(employee.id)}&plan_type=offboarding`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load offboarding plan assignments.');
    }

    planAssignmentCache.offboarding={};

    (result.data||[]).forEach(row=>{
      if(row.item_key){
        planAssignmentCache.offboarding[row.item_key]=row.assignee||'Select Employee';
      }
    });

    renderOffboardingPlanRows(planAssignmentCache.offboarding);
    return true;

  }catch(error){
    console.error('Offboarding plan assignment load error:',error);
    showToast('Could not load offboarding plan assignments.');
    return false;
  }
}

/* ================= Orientation plan ================= */
const orientationModules=[
  ['HR Orientation','Welcome to SPS\nOrg Chart\nSPS Website Overview\nSPS Policies and Benefit Summary'],
  ['IT Orientation','Your Device Access\nOffice 365 account activation\nTeams account activation and policy\nHelpdesk Services'],
  ['Accounting Orientation','Compensation & Benefits\nJob Codes\nTime Live\nClaim Expenses'],
  ['BMS Orientation','Sales (Products, Services, Partners, Customers, Contacts, RFP)\nMarketing\nEducation\nSpinnlabs'],
  ['Learning & Development','KYC - Know Your Company\nKYB - Know Your Business\nKYR - Know Your Role\nPartner Management']
];

let orientationPlanCache={};

function renderOrientationPlanRows(saved={}){
  const body=document.getElementById('orientationPlanBody');
  if(!body)return;

  body.innerHTML=orientationModules.map((module,index)=>{
    const moduleKey=`orientation-${index}`;
    const record=saved[moduleKey]||{};

    return `
      <tr>
        <td>${index+1}</td>
        <td class="preline"><b>${escapeHtml(module[0])}</b>
${escapeHtml(module[1])}</td>
        <td><input data-orientation="day-${index}" value="${escapeHtml(record.orientation_day||'')}"></td>
        <td><input data-orientation="date-${index}" type="date" value="${escapeHtml(record.orientation_date||'')}"></td>
        <td><input data-orientation="duration-${index}" placeholder="e.g. 3 hours" value="${escapeHtml(record.duration||'')}"></td>
        <td><textarea data-orientation="feedback-${index}" rows="3">${escapeHtml(record.feedback||'')}</textarea></td>
      </tr>
    `;
  }).join('');
}

async function renderOrientationPlan(){
  const employee=getEmployee();
  const body=document.getElementById('orientationPlanBody');

  if(!body)return false;

  orientationPlanCache={};
  renderOrientationPlanRows(orientationPlanCache);

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/orientation-plan/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load orientation plan.');
    }

    orientationPlanCache={};

    (result.data||[]).forEach(row=>{
      if(row.module_key){
        orientationPlanCache[row.module_key]=row;
      }
    });

    renderOrientationPlanRows(orientationPlanCache);
    return true;

  }catch(error){
    console.error('Orientation plan load error:',error);
    showToast('Could not load orientation plan.');
    return false;
  }
}

async function saveOrientationPlan(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const records=orientationModules.map((module,index)=>({
    module_key:`orientation-${index}`,
    module_name:module[0],
    orientation_day:document.querySelector(`[data-orientation="day-${index}"]`)?.value||'',
    orientation_date:document.querySelector(`[data-orientation="date-${index}"]`)?.value||'',
    duration:document.querySelector(`[data-orientation="duration-${index}"]`)?.value||'',
    feedback:document.querySelector(`[data-orientation="feedback-${index}"]`)?.value||''
  }));

  try{
    const response=await fetch(
      'api/orientation-plan/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          records
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save orientation plan.');
      return false;
    }

    orientationPlanCache={};
    records.forEach(row=>{
      orientationPlanCache[row.module_key]=row;
    });

    showToast('Orientation plan saved successfully.');
    return true;

  }catch(error){
    console.error('Orientation plan save error:',error);
    showToast('Server error while saving orientation plan.');
    return false;
  }
}

/* ================= Offboarding reasons ================= */
const offboardingReasons=[
  'Career advancement',
  'Dissatisfaction with the job or workplace',
  'Work-life balance',
  'Personal reasons',
  'Dissatisfaction with compensation and benefits',
  'Lack of alignment with company culture or values',
  'Burnout or stress'
];

let offboardingReasonCache=[];

function renderOffboardingReasons(saved=[]){
  const root=document.getElementById('offboardingReasonsList');
  if(!root)return;

  root.innerHTML=offboardingReasons.map((reason,index)=>`
    <label class="reason-row">
      <input
        type="checkbox"
        value="${index}"
        ${saved.includes(reason)?'checked':''}
      >
      <span>${escapeHtml(reason)}</span>
    </label>
  `).join('');
}

async function openOffboardingReasons(){
  const employee=getEmployee();
  const root=document.getElementById('offboardingReasonsList');

  if(!root){
    return false;
  }

  offboardingReasonCache=[];
  renderOffboardingReasons(offboardingReasonCache);
  openModal('modalOffboardingReasons');

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/offboarding-reasons/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load offboarding reasons.');
    }

    offboardingReasonCache=(result.data||[])
      .map(row=>row.reason)
      .filter(Boolean);

    renderOffboardingReasons(offboardingReasonCache);
    return true;

  }catch(error){
    console.error('Offboarding reasons load error:',error);
    showToast('Could not load offboarding reasons.');
    return false;
  }
}

async function saveOffboardingReasons(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const reasons=[
    ...document.querySelectorAll(
      '#offboardingReasonsList input:checked'
    )
  ]
    .map(input=>offboardingReasons[Number(input.value)])
    .filter(Boolean);

  try{
    const response=await fetch(
      'api/offboarding-reasons/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({
          employee_id:employee.id,
          reasons
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save offboarding reasons.');
      return false;
    }

    offboardingReasonCache=[...reasons];
    closeModal('modalOffboardingReasons');

    showToast(
      `${reasons.length} offboarding reason${reasons.length===1?'':'s'} saved.`
    );

    return true;

  }catch(error){
    console.error('Offboarding reasons save error:',error);
    showToast('Server error while saving offboarding reasons.');
    return false;
  }
}

/* ================= Initial render ================= */
// Rendering starts after employees are loaded from MySQL at the bottom of this file.

/* ================= COMPLETE COMPANY FEATURE LAYER ================= */
/* This layer completes the screenshot-driven HR workflows while keeping
   the existing Profile and Statement pages unchanged. */

function ensureSelectValue(id,value){
  const el=document.getElementById(id); if(!el)return;
  const v=value??'';
  if(v!=='' && ![...el.options].some(o=>o.value===v)){ const o=document.createElement('option');o.value=v;o.textContent=v;el.appendChild(o); }
  el.value=v;
}

/* ---------- Employee directory: extra filters, add employee, export ---------- */
let advancedLastFilteredEmployees=[...employees];
function populateEmployeeFilterOptions(){
  const fill=(id,values,label)=>{ const el=document.getElementById(id); if(!el)return; const current=el.value; const unique=[...new Set(values.filter(Boolean).filter(v=>v!=='—'))].sort((a,b)=>String(a).localeCompare(String(b))); el.innerHTML=`<option value="">${label}</option>`+unique.map(v=>`<option>${escapeHtml(v)}</option>`).join(''); el.value=current; };
  fill('empGroup',employees.map(e=>e.group),'All Groups');
  fill('empPractice',employees.map(e=>e.practice),'All Practices');
}
function updateEmployeeStats(filtered=employees){
  const all=employees;
  const set=(id,val)=>{const el=document.getElementById(id);if(el)el.textContent=val;};
  set('statTotalEmployees',all.length);
  set('statActiveEmployees',all.filter(e=>e.status==='Active').length);
  set('statInternEmployees',all.filter(e=>/intern|prob/i.test(e.job||'')).length);
  set('statHoldEmployees',all.filter(e=>e.status!=='Active'||/hold/i.test(e.job||'')).length);
  set('employeeResultCount',`${filtered.length} employee${filtered.length===1?'':'s'}`);
}
function filterEmployees(){
  const val=id=>document.getElementById(id)?.value||'';
  const q=val('empSearch').trim().toLowerCase(), dept=val('empDept'), group=val('empGroup'), practice=val('empPractice'), location=val('empLocation'), type=val('empType'), status=val('empStatus');
  const list=employees.filter(e=>{
    const hay=[e.name,e.email,e.mgr,e.dept,e.group,e.practice,e.loc,e.type,e.job,e.mobile].join(' ').toLowerCase();
    return (!q||hay.includes(q))&&(!dept||e.dept===dept)&&(!group||e.group===group)&&(!practice||e.practice===practice)&&(!location||e.loc===location)&&(!type||e.type===type)&&(!status||e.status===status);
  });
  advancedLastFilteredEmployees=list;
  renderEmployees(list); updateEmployeeStats(list);
}
function resetEmployeeFilters(){ ['empSearch','empDept','empGroup','empPractice','empLocation','empType','empStatus'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';}); filterEmployees(); }
function exportEmployees(format='csv'){
  const rows=advancedLastFilteredEmployees.length?advancedLastFilteredEmployees:employees;
  const headers=['Name','Type','Job Status','Manager','Department','Group','Practice','Location','Mobile','Email','Status'];
  const data=rows.map(e=>[e.name,e.type,e.job,e.mgr,e.dept,e.group,e.practice,e.loc,e.mobile,e.email,e.status]);
  let blob,name;
  if(format==='excel'){
    const table=`<table><tr>${headers.map(h=>`<th>${escapeHtml(h)}</th>`).join('')}</tr>${data.map(r=>`<tr>${r.map(v=>`<td>${escapeHtml(v||'')}</td>`).join('')}</tr>`).join('')}</table>`;
    blob=new Blob([`<html><head><meta charset="utf-8"></head><body>${table}</body></html>`],{type:'application/vnd.ms-excel'}); name='sps-bms-employees.xls';
  }else{
    const csv=[headers,...data].map(r=>r.map(v=>`"${String(v??'').replace(/"/g,'""')}"`).join(',')).join('\n');
    blob=new Blob([csv],{type:'text/csv;charset=utf-8'}); name='sps-bms-employees.csv';
  }
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=name; a.click(); setTimeout(()=>URL.revokeObjectURL(a.href),500); showToast(`${format==='excel'?'Excel':'CSV'} export created.`);
}
function openAddEmployeeModal(){
  ['newEmpName','newEmpManager','newEmpGroup','newEmpPractice','newEmpMobile','newEmpEmail'].forEach(id=>setFieldValue(id,''));
  ['newEmpType','newEmpJob','newEmpDept','newEmpLocation','newEmpStatus'].forEach(id=>{const el=document.getElementById(id);if(el)el.selectedIndex=0;});
  openModal('modalAddEmployee');
}
async function saveNewEmployee() {

  const getValue = id =>
    document
      .getElementById(id)
      ?.value
      .trim() || "";

  const employeeData = {

    name:
      getValue("newEmpName"),

    employee_type:
      getValue("newEmpType") ||
      "Employee",

    work_status:
      getValue("newEmpJob") ||
      "Full Time",

    email:
      getValue("newEmpEmail"),

    mobile_no:
      getValue("newEmpMobile"),

    location:
      getValue("newEmpLocation"),

    department:
      getValue("newEmpDept"),

    employee_group:
      getValue("newEmpGroup"),

    practice:
      getValue("newEmpPractice"),

    supervisor_name:
      getValue("newEmpManager"),

    status:
      getValue("newEmpStatus") ||
      "Active"
  };


  if (
    !employeeData.name ||
    !employeeData.email
  ) {

    showToast(
      "Name and email are required."
    );

    return;
  }


  try {

    const response = await fetch(
      "api/employees/create.php",
      {
        method: "POST",

        headers: {
          "Content-Type": "application/json"
        },

        body: JSON.stringify(
          employeeData
        )
      }
    );


    const result =
      await response.json();


    if (!result.success) {

      showToast(
        result.message ||
        "Could not add employee."
      );

      return;
    }


    closeModal(
      "modalAddEmployee"
    );


    showToast(
      "Employee added successfully."
    );


    /* Reload employees from MySQL */

    await loadEmployeesFromDatabase();


  } catch (error) {

    console.error(
      "Add employee error:",
      error
    );

    showToast(
      "Server error while adding employee."
    );
  }
}
/* ---------- Employee master record ---------- */
const employeeDetailFieldMap={
  name:'edField-name',type:'edField-type',workstatus:'edField-workstatus',gender:'edField-gender',email:'edField-email',personalEmail:'edField-personalEmail',cnic:'edField-cnic',dob:'edField-dob',address:'edField-address',jobTitle:'edField-jobTitle',businessArea:'edField-businessArea',linkedin:'edField-linkedin',officeNo:'edField-officeNo',mobile:'edField-mobile',emergency:'edField-emergency',homeNo:'edField-homeNo',company:'edField-company',loc:'edField-loc',officeLoc:'edField-officeLoc',dept:'edField-dept',group:'edField-group',practice:'edField-practice',hireSource:'edField-hireSource',educationLevel:'edField-educationLevel',guardianName:'edField-guardianName',guardianContact:'edField-guardianContact',guardianAddress:'edField-guardianAddress',university:'edField-university',fieldOfStudy:'edField-fieldOfStudy',passingYear:'edField-passingYear',course:'edField-course',gpa:'edField-gpa',supName:'edField-supName',supEmail:'edField-supEmail'
};
function defaultEmployeeDetail(employee) {

  const db =
    employee.databaseData || {};

  return {

    name:
      db.name ||
      employee.name ||
      "",

    type:
      db.employee_type ||
      employee.type ||
      "Employee",

    workstatus:
      db.work_status ||
      employee.job ||
      "",

    gender:
      db.gender ||
      "",

    email:
      db.email ||
      employee.email ||
      "",

    personalEmail:
      db.personal_email ||
      "",

    cnic:
      db.cnic ||
      "",

    dob:
      db.date_of_birth ||
      "",

    address:
      db.residential_address ||
      "",

    jobTitle:
      db.job_title ||
      "",

    businessArea:
      db.business_area ||
      "",

    linkedin:
      db.linkedin_url ||
      "",

    officeNo:
      db.office_no ||
      "",

    mobile:
      db.mobile_no ||
      employee.mobile ||
      "",

    emergency:
      db.emergency_no ||
      "",

    homeNo:
      db.home_no ||
      "",

    loc:
      db.location ||
      employee.loc ||
      "",

    officeLoc:
      db.office_location ||
      "",

    dept:
      db.department ||
      employee.dept ||
      "",

    group:
      db.employee_group ||
      employee.group ||
      "",

    practice:
      db.practice ||
      "",

    hireSource:
      db.hire_source ||
      "",

    company:
      db.company ||
      "",

    educationLevel:
      db.educational_level ||
      "",

    supName:
      db.supervisor_name ||
      employee.mgr ||
      "",

    supEmail:
      db.supervisor_email ||
      "",

    guardianName:
      db.guardian_name ||
      "",

    guardianContact:
      db.guardian_contact ||
      "",

    guardianAddress:
      db.guardian_address ||
      "",

    university:
      "",

    fieldOfStudy:
      "",

    passingYear:
      "",

    course:
      "",

    gpa:
      "",

    spsCorporate:
      Number(db.sps_corporate || 0) === 1,

    files: {}
  };
}
function getEmployeeDetailData(){
  return defaultEmployeeDetail(getEmployee());
}
function populateSupervisorOptions(value){
  const el=document.getElementById('edField-supName'); if(!el)return; const names=[...new Set(employees.map(e=>e.name).filter(n=>n!==selectedEmployeeName))].sort(); el.innerHTML='<option value="">Select Supervisor</option>'+names.map(n=>`<option>${escapeHtml(n)}</option>`).join(''); ensureSelectValue('edField-supName',value||'');
}
function rememberEmployeeFile(kind,input){
  const file=input.files?.[0];
  if(!file)return;

  const note=document.getElementById(`edFileNote-${kind}`);
  if(note){
    note.textContent=`Selected: ${file.name}`;
  }

  showToast(`${file.name} selected. Use the Attachments section to save files permanently.`);
}
function renderEmployeeFileNotes(data){ ['picture','degree','cnicFront','cnicBack','resume'].forEach(kind=>{const n=document.getElementById(`edFileNote-${kind}`);if(n)n.textContent=data.files?.[kind]?.name?`Current: ${data.files[kind].name}`:'';}); }
function renderEmployeeDetailAdvanced(){
  const e=getEmployee(),data=getEmployeeDetailData();
  const title=document.getElementById('edName'); if(title)title.textContent=e.name;
  Object.entries(employeeDetailFieldMap).forEach(([key,id])=>{ if(['type','workstatus','gender','jobTitle','company','loc','officeLoc','dept','group','practice','hireSource','educationLevel'].includes(key))ensureSelectValue(id,data[key]??''); else setFieldValue(id,data[key]??''); });
  populateSupervisorOptions(data.supName||e.mgr); setFieldValue('edField-supEmail',data.supEmail||(data.supName?guessEmailFromName(data.supName):''));
  const corp=document.getElementById('edField-spsCorporate');if(corp)corp.checked=!!data.spsCorporate;
  const badge=document.getElementById('edJobTitleBadge');if(badge)badge.textContent=data.jobTitle||'No job title found';
  renderEmployeeFileNotes(data); renderAdvancedDetailTables(); renderKpiTables(); renderCertifications(); loadLoadedCost();
  loadEmployeeEducation();
  loadCorporateRoles();
  loadDepartmentalRoles();
  loadEmploymentHistory();
  loadDepartmentCustomers();
  loadProjects();
  loadProducts();
  loadLearningDevelopment();
  loadAttachments();
  loadCommunicationSkills();
  loadBadges();
  loadCertifications();
  loadKpiData();
}
function viewEmployee(name){ setSelectedEmployee(name); closeAllRowMenus(); goPage('employee-detail'); renderEmployeeDetailAdvanced(); }
async function saveEmployeeDetails() {

  const employee =
    getEmployee();

  if (!employee || !employee.id) {
    showToast(
      "Employee database ID not found."
    );

    return;
  }


  const value = id =>
    document
      .getElementById(id)
      ?.value
      .trim() || "";


  const payload = {

    id:
      employee.id,

    name:
      value("edField-name"),

    employee_type:
      value("edField-type"),

    work_status:
      value("edField-workstatus"),

    gender:
      value("edField-gender"),

    email:
      value("edField-email"),

    personal_email:
      value("edField-personalEmail"),

    cnic:
      value("edField-cnic"),

    date_of_birth:
      value("edField-dob"),

    residential_address:
      value("edField-address"),

    job_title:
      value("edField-jobTitle"),

    business_area:
      value("edField-businessArea"),

    linkedin_url:
      value("edField-linkedin"),

    office_no:
      value("edField-officeNo"),

    mobile_no:
      value("edField-mobile"),

    emergency_no:
      value("edField-emergency"),

    home_no:
      value("edField-homeNo"),

    location:
      value("edField-loc"),

    office_location:
      value("edField-officeLoc"),

    department:
      value("edField-dept"),

    employee_group:
      value("edField-group"),

    practice:
      value("edField-practice"),

    hire_source:
      value("edField-hireSource"),

    company:
      value("edField-company"),

    educational_level:
      value("edField-educationLevel"),

    guardian_name:
      value("edField-guardianName"),

    guardian_contact:
      value("edField-guardianContact"),

    guardian_address:
      value("edField-guardianAddress"),

    sps_corporate:
      document.getElementById("edField-spsCorporate")?.checked ? 1 : 0,

    supervisor_name:
      value("edField-supName"),

    supervisor_email:
      value("edField-supEmail"),

    status:
      employee.status || "Active"
  };


  if (
    !payload.name ||
    !payload.email
  ) {

    showToast(
      "Name and email are required."
    );

    return;
  }


  try {

    const response =
      await fetch(
        "api/employees/update.php",
        {

          method: "POST",

          headers: {
            "Content-Type":
              "application/json"
          },

          body:
            JSON.stringify(
              payload
            )

        }
      );


    const result =
      await response.json();


    if (!result.success) {

      showToast(
        result.message ||
        "Could not update employee."
      );

      return;
    }


    const educationSaved =
      await saveEmployeeEducation();

    if (!educationSaved) {
      return;
    }


    const updatedName =
      payload.name;


    await loadEmployeesFromDatabase();


    const updatedEmployee =
      employees.find(
        item =>
          Number(item.id) ===
          Number(payload.id)
      );


    if (updatedEmployee) {

      selectedEmployeeName =
        updatedEmployee.name;

    } else {

      selectedEmployeeName =
        updatedName;

    }


    syncEmployeeContext();

    renderEmployeeDetailAdvanced();


    showToast(
      "Employee details saved successfully."
    );


  } catch (error) {

    console.error(
      "Employee update error:",
      error
    );

    showToast(
      "Server error while saving employee details."
    );

  }
}
/* ---------- CRUD records on Employee Detail ---------- */
const advancedRecordSchemas={
  corporateRoles:{title:'Corporate Role',fields:[['role','Role'],['level','Level'],['levelTitle','Level Title'],['rank','Rank']]},
  departmentalRoles:{title:'Departmental Role',fields:[['role','Role'],['level','Level'],['levelTitle','Level Title'],['rank','Rank']]},
  employmentHistory:{title:'Employment History',fields:[['startDate','Start Date','date'],['endDate','End Date','date'],['jobTitle','Job Title'],['corporateRole','Corporate Role'],['departmentRole','Department Role'],['functionRole','Functional Role'],['duration','Duration']]},
  departmentCustomers:{title:'Department Customer',fields:[['id','ID'],['name','Customer Name']]},
  projects:{title:'Project',fields:[['id','ID'],['name','Project Name']]},
  products:{title:'Product',fields:[['id','ID'],['name','Product Name']]},
  learning:{title:'Learning & Development',fields:[['course','Course Name'],['training','Training Taken'],['test','Test Taken']]},
  attachment:{title:'Attachment',storage:'attachments',fields:[['title','Title'],['file','File','file']]},
  communication:{title:'Communication Skill',fields:[['addedBy','Added By'],['speaking','Speaking'],['writing','Writing'],['listening','Listening'],['date','Date','date']]},
  badges:{title:'Employee Badge',fields:[['vendor','Vendor'],['group','Group'],['practice','Practice'],['product','Product'],['title','Title'],['url','URL','url'],['completed','Completed On','date']]}
};
let advancedRecordEditorState={kind:null,index:-1};
let corporateRolesDb=[];
let departmentalRolesDb=[];
let employmentHistoryDb=[];
let departmentCustomersDb=[];
let projectsDb=[];
let productsDb=[];
let learningDevelopmentDb=[];
let attachmentsDb=[];
let communicationSkillsDb=[];
let badgesDb=[];
let certificationsDb=[];
async function loadEmployeeEducation() {

  const employee = getEmployee();

  if (!employee || !employee.id) {
    return;
  }

  try {

    const response = await fetch(
      `api/education/get.php?employee_id=${employee.id}`
    );

    const result = await response.json();

    if (!result.success) {
      return;
    }

    const data = result.data;

    if (!data) {

      setFieldValue(
        "edField-university",
        ""
      );

      setFieldValue(
        "edField-fieldOfStudy",
        ""
      );

      setFieldValue(
        "edField-passingYear",
        ""
      );

      setFieldValue(
        "edField-course",
        ""
      );

      setFieldValue(
        "edField-gpa",
        ""
      );

      return;
    }

    setFieldValue(
      "edField-university",
      data.university || ""
    );

    setFieldValue(
      "edField-fieldOfStudy",
      data.field_of_study || ""
    );

    setFieldValue(
      "edField-passingYear",
      data.passing_year || ""
    );

    setFieldValue(
      "edField-course",
      data.course || ""
    );

    setFieldValue(
      "edField-gpa",
      data.grade_gpa || ""
    );

  } catch (error) {

    console.error(
      "Education load error:",
      error
    );
  }
}
async function saveEmployeeEducation() {

  const employee = getEmployee();

  if (!employee || !employee.id) {

    showToast(
      "Employee ID not found."
    );

    return false;
  }

  const value = id =>
    document
      .getElementById(id)
      ?.value
      .trim() || "";

  const payload = {

    employee_id:
      employee.id,

    university:
      value("edField-university"),

    field_of_study:
      value("edField-fieldOfStudy"),

    passing_year:
      value("edField-passingYear"),

    course:
      value("edField-course"),

    grade_gpa:
      value("edField-gpa")
  };

  try {

    const response = await fetch(
      "api/education/save.php",
      {
        method: "POST",

        headers: {
          "Content-Type":
            "application/json"
        },

        body:
          JSON.stringify(payload)
      }
    );

    const result =
      await response.json();

    if (!result.success) {

      showToast(
        result.message ||
        "Could not save education."
      );

      return false;
    }

    return true;

  } catch (error) {

    console.error(
      "Education save error:",
      error
    );

    showToast(
      "Server error while saving education."
    );

    return false;
  }
}
async function loadCorporateRoles() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    corporateRolesDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/corporate-roles/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load corporate roles.');
    }

    corporateRolesDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      role:row.role||'',
      level:row.level||'',
      levelTitle:row.level_title||'',
      rank:row.rank_value||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Corporate roles load error:',error);
    corporateRolesDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load corporate roles.');
  }
}

async function loadDepartmentalRoles() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    departmentalRolesDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/departmental-roles/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load departmental roles.');
    }

    departmentalRolesDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      role:row.role||'',
      level:row.level||'',
      levelTitle:row.level_title||'',
      rank:row.rank_value||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Departmental roles load error:',error);
    departmentalRolesDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load departmental roles.');
  }
}

async function loadEmploymentHistory() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    employmentHistoryDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/employment-history/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load employment history.');
    }

    employmentHistoryDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      startDate:row.start_date||'',
      endDate:row.end_date||'',
      jobTitle:row.job_title||'',
      corporateRole:row.corporate_role||'',
      departmentRole:row.department_role||'',
      functionRole:row.functional_role||'',
      duration:row.duration||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Employment history load error:',error);
    employmentHistoryDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load employment history.');
  }
}

async function loadDepartmentCustomers() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    departmentCustomersDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/department-customers/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load department customers.');
    }

    departmentCustomersDb=(result.data||[]).map(row=>({
      dbId:Number(row.id),
      id:row.customer_code||'',
      name:row.customer_name||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Department customers load error:',error);
    departmentCustomersDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load department customers.');
  }
}


async function loadProjects() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    projectsDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/projects/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load projects.');
    }

    projectsDb=(result.data||[]).map(row=>({
      dbId:Number(row.id),
      id:row.project_code||'',
      name:row.project_name||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Projects load error:',error);
    projectsDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load projects.');
  }
}


async function loadProducts() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    productsDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/products/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load products.');
    }

    productsDb=(result.data||[]).map(row=>({
      dbId:Number(row.id),
      id:row.product_code||'',
      name:row.product_name||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Products load error:',error);
    productsDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load products.');
  }
}

async function loadLearningDevelopment() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    learningDevelopmentDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/learning-development/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load learning and development records.');
    }

    learningDevelopmentDb=(result.data||[]).map(row=>({
      dbId:Number(row.id),
      course:row.course_name||'',
      training:row.training_taken||'',
      test:row.test_taken||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Learning & Development load error:',error);
    learningDevelopmentDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load Learning & Development.');
  }
}


async function loadAttachments() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    attachmentsDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/attachments/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load attachments.');
    }

    attachmentsDb=(result.data||[]).map(row=>({
      dbId:Number(row.id),
      title:row.title||'',
      file:row.original_file_name||'',
      storedFileName:row.stored_file_name||'',
      filePath:row.file_path||'',
      fileType:row.file_type||'',
      fileSize:Number(row.file_size||0),
      createdAt:row.created_at||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Attachments load error:',error);
    attachmentsDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load attachments.');
  }
}


async function loadCommunicationSkills() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    communicationSkillsDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/communication-skills/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load communication skills.');
    }

    communicationSkillsDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      addedBy:row.added_by||'',
      speaking:row.speaking||'',
      writing:row.writing||'',
      listening:row.listening||'',
      date:row.record_date||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Communication skills load error:',error);
    communicationSkillsDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load communication skills.');
  }
}

async function loadBadges() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    badgesDb=[];
    renderAdvancedDetailTables();
    return;
  }

  try{
    const response=await fetch(
      `api/badges/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load badges.');
    }

    badgesDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      vendor:row.vendor||'',
      group:row.badge_group||'',
      practice:row.practice||'',
      product:row.product||'',
      title:row.title||'',
      url:row.badge_url||'',
      completed:row.completed_on||''
    }));

    renderAdvancedDetailTables();

  }catch(error){
    console.error('Badges load error:',error);
    badgesDb=[];
    renderAdvancedDetailTables();
    showToast('Could not load badges.');
  }
}


async function loadCertifications() {
  const employee=getEmployee();

  if(!employee || !employee.id){
    certificationsDb=[];
    renderCertifications();
    return;
  }

  try{
    const response=await fetch(
      `api/certifications/list.php?employee_id=${employee.id}`,
      {cache:'no-store'}
    );

    if(!response.ok){
      throw new Error(`HTTP ${response.status}`);
    }

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load certifications.');
    }

    certificationsDb=(result.data||[]).map(row=>({
      id:Number(row.id),
      vendor:row.vendor||'',
      group:row.certification_group||'',
      practice:row.practice||'',
      product:row.product||'',
      title:row.title||'',
      code:row.certification_code||'',
      url:row.certification_url||'',
      type:row.certification_type||'Certification',
      completed:row.completed_on||''
    }));

    renderCertifications();

  }catch(error){
    console.error('Certifications load error:',error);
    certificationsDb=[];
    renderCertifications();
    showToast('Could not load certifications.');
  }
}

function actionButtons(kind,index){ return `<div class="table-actions"><button class="icon-action" title="Edit" onclick="openRecordEditor('${kind}',${index})">✎</button><button class="icon-action danger" title="Delete" onclick="deleteDetailRecord('${kind}',${index})">×</button></div>`; }
function attachmentActionButtons(index){ return `<div class="table-actions"><button class="icon-action danger" title="Delete" onclick="deleteDetailRecord('attachment',${index})">×</button></div>`; }
function renderAdvancedDetailTables(){
  const render=(id,rows,fn,colspan)=>{const b=document.getElementById(id);if(!b)return;b.innerHTML=rows.length?rows.map(fn).join(''):`<tr class="empty-row"><td colspan="${colspan}">No records found.</td></tr>`;};
  render('corporateRolesBody',corporateRolesDb,(r,i)=>`<tr><td>${escapeHtml(r.role)}</td><td>${escapeHtml(r.level)}</td><td>${escapeHtml(r.levelTitle)}</td><td>${escapeHtml(r.rank)}</td><td>${actionButtons('corporateRoles',i)}</td></tr>`,5);
  render('departmentalRolesBody',departmentalRolesDb,(r,i)=>`<tr><td>${escapeHtml(r.role)}</td><td>${escapeHtml(r.level)}</td><td>${escapeHtml(r.levelTitle)}</td><td>${escapeHtml(r.rank)}</td><td>${actionButtons('departmentalRoles',i)}</td></tr>`,5);
  render('employmentHistoryBody',employmentHistoryDb,(r,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(r.startDate||'—')}</td><td>${escapeHtml(r.endDate||'Present')}</td><td>${escapeHtml(r.jobTitle)}</td><td>${escapeHtml(r.corporateRole)}</td><td>${escapeHtml(r.departmentRole)}</td><td>${escapeHtml(r.functionRole)}</td><td>${escapeHtml(r.duration)}</td><td>${actionButtons('employmentHistory',i)}</td></tr>`,9);
  render('departmentCustomersBody',departmentCustomersDb,(r,i)=>`<tr><td>${escapeHtml(r.id||'—')}</td><td>${escapeHtml(r.name)}</td><td>${actionButtons('departmentCustomers',i)}</td></tr>`,3);
  render('projectsBody',projectsDb,(r,i)=>`<tr><td>${escapeHtml(r.id||'—')}</td><td>${escapeHtml(r.name)}</td><td>${actionButtons('projects',i)}</td></tr>`,3);
  render('productsBody',productsDb,(r,i)=>`<tr><td>${escapeHtml(r.id||'—')}</td><td>${escapeHtml(r.name)}</td><td>${actionButtons('products',i)}</td></tr>`,3);
  render('learningBody',learningDevelopmentDb,(r,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(r.course)}</td><td>${escapeHtml(r.training)}</td><td>${escapeHtml(r.test)}</td><td>${actionButtons('learning',i)}</td></tr>`,5);
  render('attachmentsBody',attachmentsDb,(r,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(r.title)}</td><td>${r.filePath?`<a href="${escapeHtml(r.filePath)}" target="_blank" rel="noopener">${escapeHtml(r.file||'Open file')}</a>`:escapeHtml(r.file||'—')}</td><td>${attachmentActionButtons(i)}</td></tr>`,4);
  render('communicationBody',communicationSkillsDb,(r,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(r.addedBy)}</td><td>${escapeHtml(r.speaking)}</td><td>${escapeHtml(r.writing)}</td><td>${escapeHtml(r.listening)}</td><td>${escapeHtml(r.date)}</td><td>${actionButtons('communication',i)}</td></tr>`,7);
  render('badgeTableBody',badgesDb,(r,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(r.vendor)}</td><td>${escapeHtml(r.group)}</td><td>${escapeHtml(r.practice)}</td><td>${escapeHtml(r.product)}</td><td>${escapeHtml(r.title)}</td><td>${r.url?`<a href="${escapeHtml(r.url)}" target="_blank" rel="noopener">Open</a>`:'—'}</td><td>${escapeHtml(r.completed||'—')}</td><td>${actionButtons('badges',i)}</td></tr>`,9);
}
function openRecordEditor(kind,index=-1){
  const schema=advancedRecordSchemas[kind];
  if(!schema)return;

  advancedRecordEditorState={kind,index};

  let row={};

  if(kind==='corporateRoles'){
    row=index>=0?(corporateRolesDb[index]||{}):{};
  }else if(kind==='departmentalRoles'){
    row=index>=0?(departmentalRolesDb[index]||{}):{};
  }else if(kind==='employmentHistory'){
    row=index>=0?(employmentHistoryDb[index]||{}):{};
  }else if(kind==='departmentCustomers'){
    row=index>=0?(departmentCustomersDb[index]||{}):{};
  }else if(kind==='projects'){
    row=index>=0?(projectsDb[index]||{}):{};
  }else if(kind==='products'){
    row=index>=0?(productsDb[index]||{}):{};
  }else if(kind==='learning'){
    row=index>=0?(learningDevelopmentDb[index]||{}):{};
  }else if(kind==='attachment'){
    row=index>=0?(attachmentsDb[index]||{}):{};
  }else if(kind==='communication'){
    row=index>=0?(communicationSkillsDb[index]||{}):{};
  }else if(kind==='badges'){
    row=index>=0?(badgesDb[index]||{}):{};
  }else{
    showToast('This record type is not available.');
    return;
  }

  const title=document.getElementById('recordModalTitle');
  if(title)title.textContent=`${index>=0?'Edit':'Add'} ${schema.title}`;

  const root=document.getElementById('recordFormFields');
  if(!root)return;

  root.innerHTML=schema.fields.map(([key,label,type='text'])=>{
    const value=row[key]||'';

    if(type==='file'){
      return `<div class="field">
        <label>${label}</label>
        <input id="record-${key}" type="file">
        <small class="file-note">${value?`Current: ${escapeHtml(value)}`:'No file selected.'}</small>
      </div>`;
    }

    return `<div class="field">
      <label>${label}</label>
      <input id="record-${key}" type="${type}" value="${escapeHtml(value)}">
    </div>`;
  }).join('');

  openModal('modalRecordEditor');
}

async function saveRecordEditor(){
  const {kind,index}=advancedRecordEditorState;
  const schema=advancedRecordSchemas[kind];

  if(!schema)return;

  /* Corporate Roles are stored in MySQL. */
  if(kind==='corporateRoles'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const role=get('role');

    if(!role){
      showToast('Role is required.');
      return;
    }

    const currentRole=index>=0?corporateRolesDb[index]:null;

    const payload={
      id:currentRole?.id||0,
      employee_id:employee.id,
      role,
      level:get('level'),
      level_title:get('levelTitle'),
      rank_value:get('rank')
    };

    try{
      const response=await fetch('api/corporate-roles/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save corporate role.');
        return;
      }

      await loadCorporateRoles();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Corporate role updated successfully.':'Corporate role added successfully.');
      return;

    }catch(error){
      console.error('Corporate role save error:',error);
      showToast('Server error while saving corporate role.');
      return;
    }
  }

  /* Departmental Roles are stored in MySQL. */
  if(kind==='departmentalRoles'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const role=get('role');

    if(!role){
      showToast('Role is required.');
      return;
    }

    const currentRole=index>=0?departmentalRolesDb[index]:null;

    const payload={
      id:currentRole?.id||0,
      employee_id:employee.id,
      role,
      level:get('level'),
      level_title:get('levelTitle'),
      rank_value:get('rank')
    };

    try{
      const response=await fetch('api/departmental-roles/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save departmental role.');
        return;
      }

      await loadDepartmentalRoles();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Departmental role updated successfully.':'Departmental role added successfully.');
      return;

    }catch(error){
      console.error('Departmental role save error:',error);
      showToast('Server error while saving departmental role.');
      return;
    }
  }

  /* Employment History is stored in MySQL. */
  if(kind==='employmentHistory'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const jobTitle=get('jobTitle');

    if(!jobTitle){
      showToast('Job title is required.');
      return;
    }

    const currentRecord=index>=0?employmentHistoryDb[index]:null;

    const payload={
      id:currentRecord?.id||0,
      employee_id:employee.id,
      start_date:get('startDate'),
      end_date:get('endDate'),
      job_title:jobTitle,
      corporate_role:get('corporateRole'),
      department_role:get('departmentRole'),
      functional_role:get('functionRole'),
      duration:get('duration')
    };

    try{
      const response=await fetch('api/employment-history/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save employment history.');
        return;
      }

      await loadEmploymentHistory();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Employment history updated successfully.':'Employment history added successfully.');
      return;

    }catch(error){
      console.error('Employment history save error:',error);
      showToast('Server error while saving employment history.');
      return;
    }
  }

  /* Department Customers are stored in MySQL. */
  if(kind==='departmentCustomers'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const customerName=get('name');

    if(!customerName){
      showToast('Customer name is required.');
      return;
    }

    const currentRecord=index>=0?departmentCustomersDb[index]:null;

    const payload={
      id:currentRecord?.dbId||0,
      employee_id:employee.id,
      customer_code:get('id'),
      customer_name:customerName
    };

    try{
      const response=await fetch('api/department-customers/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save department customer.');
        return;
      }

      await loadDepartmentCustomers();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Department customer updated successfully.':'Department customer added successfully.');
      return;

    }catch(error){
      console.error('Department customer save error:',error);
      showToast('Server error while saving department customer.');
      return;
    }
  }


  /* Projects are stored in MySQL. */
  if(kind==='projects'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const projectName=get('name');

    if(!projectName){
      showToast('Project name is required.');
      return;
    }

    const currentRecord=index>=0?projectsDb[index]:null;

    const payload={
      id:currentRecord?.dbId||0,
      employee_id:employee.id,
      project_code:get('id'),
      project_name:projectName
    };

    try{
      const response=await fetch('api/projects/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save project.');
        return;
      }

      await loadProjects();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Project updated successfully.':'Project added successfully.');
      return;

    }catch(error){
      console.error('Project save error:',error);
      showToast('Server error while saving project.');
      return;
    }
  }

  /* Products are stored in MySQL. */
  if(kind==='products'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const productName=get('name');

    if(!productName){
      showToast('Product name is required.');
      return;
    }

    const currentRecord=index>=0?productsDb[index]:null;

    const payload={
      id:currentRecord?.dbId||0,
      employee_id:employee.id,
      product_code:get('id'),
      product_name:productName
    };

    try{
      const response=await fetch('api/products/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save product.');
        return;
      }

      await loadProducts();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Product updated successfully.':'Product added successfully.');
      return;

    }catch(error){
      console.error('Product save error:',error);
      showToast('Server error while saving product.');
      return;
    }
  }

  /* Learning & Development is stored in MySQL. */
  if(kind==='learning'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const courseName=get('course');

    if(!courseName){
      showToast('Course name is required.');
      return;
    }

    const currentRecord=index>=0?learningDevelopmentDb[index]:null;

    const payload={
      id:currentRecord?.dbId||0,
      employee_id:employee.id,
      course_name:courseName,
      training_taken:get('training'),
      test_taken:get('test')
    };

    try{
      const response=await fetch('api/learning-development/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save learning record.');
        return;
      }

      await loadLearningDevelopment();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Learning record updated successfully.':'Learning record added successfully.');
      return;

    }catch(error){
      console.error('Learning & Development save error:',error);
      showToast('Server error while saving learning record.');
      return;
    }
  }


  /* Attachments are uploaded to the server and stored in MySQL. */
  if(kind==='attachment'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    if(index>=0){
      showToast('To replace an attachment, delete it and upload a new file.');
      return;
    }

    const title=document.getElementById('record-title')?.value.trim()||'';
    const fileInput=document.getElementById('record-file');
    const file=fileInput?.files?.[0];

    if(!title){
      showToast('Attachment title is required.');
      return;
    }

    if(!file){
      showToast('Please select a file.');
      return;
    }

    const formData=new FormData();
    formData.append('employee_id',employee.id);
    formData.append('title',title);
    formData.append('file',file);

    try{
      const response=await fetch('api/attachments/upload.php',{
        method:'POST',
        body:formData
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not upload attachment.');
        return;
      }

      await loadAttachments();
      closeModal('modalRecordEditor');
      showToast('Attachment uploaded successfully.');
      return;

    }catch(error){
      console.error('Attachment upload error:',error);
      showToast('Server error while uploading attachment.');
      return;
    }
  }


  /* Communication Skills are stored in MySQL. */
  if(kind==='communication'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const currentRecord=index>=0?communicationSkillsDb[index]:null;

    const payload={
      id:currentRecord?.id||0,
      employee_id:employee.id,
      added_by:get('addedBy'),
      speaking:get('speaking'),
      writing:get('writing'),
      listening:get('listening'),
      record_date:get('date')
    };

    try{
      const response=await fetch('api/communication-skills/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save communication skill.');
        return;
      }

      await loadCommunicationSkills();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Communication skill updated successfully.':'Communication skill added successfully.');
      return;

    }catch(error){
      console.error('Communication skill save error:',error);
      showToast('Server error while saving communication skill.');
      return;
    }
  }

  /* Employee Badges are stored in MySQL. */
  if(kind==='badges'){
    const employee=getEmployee();

    if(!employee || !employee.id){
      showToast('Employee ID not found.');
      return;
    }

    const get=key=>document.getElementById(`record-${key}`)?.value.trim()||'';
    const title=get('title');

    if(!title){
      showToast('Badge title is required.');
      return;
    }

    const currentRecord=index>=0?badgesDb[index]:null;

    const payload={
      id:currentRecord?.id||0,
      employee_id:employee.id,
      vendor:get('vendor'),
      badge_group:get('group'),
      practice:get('practice'),
      product:get('product'),
      title,
      badge_url:get('url'),
      completed_on:get('completed')
    };

    try{
      const response=await fetch('api/badges/save.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not save badge.');
        return;
      }

      await loadBadges();
      closeModal('modalRecordEditor');
      showToast(index>=0?'Badge updated successfully.':'Badge added successfully.');
      return;

    }catch(error){
      console.error('Badge save error:',error);
      showToast('Server error while saving badge.');
      return;
    }
  }

  showToast('This record type is not available.');
  return;
}

async function deleteDetailRecord(kind,index){
  /* Corporate Roles are deleted from MySQL. */
  if(kind==='corporateRoles'){
    const role=corporateRolesDb[index];

    if(!role || !role.id){
      showToast('Corporate role not found.');
      return;
    }

    try{
      const response=await fetch('api/corporate-roles/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:role.id})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete corporate role.');
        return;
      }

      await loadCorporateRoles();
      showToast('Corporate role deleted successfully.');

    }catch(error){
      console.error('Corporate role delete error:',error);
      showToast('Server error while deleting corporate role.');
    }

    return;
  }

  /* Departmental Roles are deleted from MySQL. */
  if(kind==='departmentalRoles'){
    const role=departmentalRolesDb[index];

    if(!role || !role.id){
      showToast('Departmental role not found.');
      return;
    }

    try{
      const response=await fetch('api/departmental-roles/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:role.id})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete departmental role.');
        return;
      }

      await loadDepartmentalRoles();
      showToast('Departmental role deleted successfully.');

    }catch(error){
      console.error('Departmental role delete error:',error);
      showToast('Server error while deleting departmental role.');
    }

    return;
  }

  /* Employment History is deleted from MySQL. */
  if(kind==='employmentHistory'){
    const record=employmentHistoryDb[index];

    if(!record || !record.id){
      showToast('Employment history record not found.');
      return;
    }

    try{
      const response=await fetch('api/employment-history/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.id})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete employment history.');
        return;
      }

      await loadEmploymentHistory();
      showToast('Employment history deleted successfully.');

    }catch(error){
      console.error('Employment history delete error:',error);
      showToast('Server error while deleting employment history.');
    }

    return;
  }

  /* Department Customers are deleted from MySQL. */
  if(kind==='departmentCustomers'){
    const record=departmentCustomersDb[index];

    if(!record || !record.dbId){
      showToast('Department customer not found.');
      return;
    }

    try{
      const response=await fetch('api/department-customers/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.dbId})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete department customer.');
        return;
      }

      await loadDepartmentCustomers();
      showToast('Department customer deleted successfully.');

    }catch(error){
      console.error('Department customer delete error:',error);
      showToast('Server error while deleting department customer.');
    }

    return;
  }


  /* Projects are deleted from MySQL. */
  if(kind==='projects'){
    const record=projectsDb[index];

    if(!record || !record.dbId){
      showToast('Project not found.');
      return;
    }

    try{
      const response=await fetch('api/projects/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.dbId})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete project.');
        return;
      }

      await loadProjects();
      showToast('Project deleted successfully.');

    }catch(error){
      console.error('Project delete error:',error);
      showToast('Server error while deleting project.');
    }

    return;
  }

  /* Products are deleted from MySQL. */
  if(kind==='products'){
    const record=productsDb[index];

    if(!record || !record.dbId){
      showToast('Product not found.');
      return;
    }

    try{
      const response=await fetch('api/products/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.dbId})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete product.');
        return;
      }

      await loadProducts();
      showToast('Product deleted successfully.');

    }catch(error){
      console.error('Product delete error:',error);
      showToast('Server error while deleting product.');
    }

    return;
  }

  /* Learning & Development records are deleted from MySQL. */
  if(kind==='learning'){
    const record=learningDevelopmentDb[index];

    if(!record || !record.dbId){
      showToast('Learning record not found.');
      return;
    }

    try{
      const response=await fetch('api/learning-development/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.dbId})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete learning record.');
        return;
      }

      await loadLearningDevelopment();
      showToast('Learning record deleted successfully.');

    }catch(error){
      console.error('Learning & Development delete error:',error);
      showToast('Server error while deleting learning record.');
    }

    return;
  }


  /* Attachments are deleted from MySQL and the uploads folder. */
  if(kind==='attachment'){
    const record=attachmentsDb[index];

    if(!record || !record.dbId){
      showToast('Attachment not found.');
      return;
    }

    try{
      const response=await fetch('api/attachments/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.dbId})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete attachment.');
        return;
      }

      await loadAttachments();
      showToast('Attachment deleted successfully.');

    }catch(error){
      console.error('Attachment delete error:',error);
      showToast('Server error while deleting attachment.');
    }

    return;
  }


  /* Communication Skills are deleted from MySQL. */
  if(kind==='communication'){
    const record=communicationSkillsDb[index];

    if(!record || !record.id){
      showToast('Communication skill record not found.');
      return;
    }

    try{
      const response=await fetch('api/communication-skills/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.id})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete communication skill.');
        return;
      }

      await loadCommunicationSkills();
      showToast('Communication skill deleted successfully.');

    }catch(error){
      console.error('Communication skill delete error:',error);
      showToast('Server error while deleting communication skill.');
    }

    return;
  }

  /* Employee Badges are deleted from MySQL. */
  if(kind==='badges'){
    const record=badgesDb[index];

    if(!record || !record.id){
      showToast('Badge not found.');
      return;
    }

    try{
      const response=await fetch('api/badges/delete.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:record.id})
      });

      const result=await response.json();

      if(!result.success){
        showToast(result.message||'Could not delete badge.');
        return;
      }

      await loadBadges();
      showToast('Badge deleted successfully.');

    }catch(error){
      console.error('Badge delete error:',error);
      showToast('Server error while deleting badge.');
    }

    return;
  }

  showToast('This record type is not available.');
  return;
}

/* ---------- Certifications ---------- */
let certEditIndex=-1;

function openCertificationModal(index=-1){
  certEditIndex=index;

  const c=index>=0
    ? (certificationsDb[index]||{})
    : {};

  const title=document.getElementById('certModalTitle');
  if(title){
    title.textContent=index>=0
      ? 'Edit Certification'
      : 'Add Certification';
  }

  const ids={
    certVendor:'vendor',
    certGroup:'group',
    certPractice:'practice',
    certProduct:'product',
    certTitle:'title',
    certCode:'code',
    certUrl:'url',
    certType:'type',
    certCompleted:'completed'
  };

  Object.entries(ids).forEach(([id,key])=>{
    if(id==='certType'){
      ensureSelectValue(id,c[key]||'Certification');
    }else{
      setFieldValue(id,c[key]||'');
    }
  });

  openModal('modalCertification');
}

async function saveCertification(){
  const employee=getEmployee();

  if(!employee || !employee.id){
    showToast('Employee ID not found.');
    return;
  }

  const get=id=>document.getElementById(id)?.value.trim()||'';

  const vendor=get('certVendor');
  const title=get('certTitle');

  if(!vendor || !title){
    showToast('Vendor and title are required.');
    return;
  }

  const current=certEditIndex>=0
    ? certificationsDb[certEditIndex]
    : null;

  const payload={
    id:current?.id||0,
    employee_id:employee.id,
    vendor,
    certification_group:get('certGroup'),
    practice:get('certPractice'),
    product:get('certProduct'),
    title,
    certification_code:get('certCode'),
    certification_url:get('certUrl'),
    certification_type:get('certType')||'Certification',
    completed_on:get('certCompleted')
  };

  try{
    const response=await fetch('api/certifications/save.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify(payload)
    });

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save certification.');
      return;
    }

    await loadCertifications();
    closeModal('modalCertification');
    showToast(certEditIndex>=0
      ? 'Certification updated successfully.'
      : 'Certification added successfully.');
    certEditIndex=-1;

  }catch(error){
    console.error('Certification save error:',error);
    showToast('Server error while saving certification.');
  }
}

async function deleteCertification(index){
  const certification=certificationsDb[index];

  if(!certification || !certification.id){
    showToast('Certification not found.');
    return;
  }

  try{
    const response=await fetch('api/certifications/delete.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({id:certification.id})
    });

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not delete certification.');
      return;
    }

    await loadCertifications();
    showToast('Certification deleted successfully.');

  }catch(error){
    console.error('Certification delete error:',error);
    showToast('Server error while deleting certification.');
  }
}

function renderCertifications(){
  const body=document.getElementById('certTableBody');
  if(!body)return;

  body.innerHTML=certificationsDb.length
    ? certificationsDb.map((c,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(c.vendor)}</td><td>${escapeHtml(c.group||'—')}</td><td>${escapeHtml(c.practice||'—')}</td><td>${escapeHtml(c.product||'—')}</td><td>${escapeHtml(c.title)}</td><td>${escapeHtml(c.code||'—')}</td><td>${c.url?`<a href="${escapeHtml(c.url)}" target="_blank" rel="noopener">Open</a>`:'—'}</td><td>${escapeHtml(c.type||'Certification')}</td><td>${escapeHtml(c.completed||'—')}</td><td>${actionButtonsForCert(i)}</td></tr>`).join('')
    : '<tr class="empty-row"><td colspan="11">No certifications on file yet — use “Add Certification” to record one.</td></tr>';
}

function actionButtonsForCert(i){
  return `<div class="table-actions"><button class="icon-action" title="Edit" onclick="openCertificationModal(${i})">✎</button><button class="icon-action danger" title="Delete" onclick="deleteCertification(${i})">×</button></div>`;
}

/* ---------- KPI matrices ---------- */
const kpiBodies={
  personalLeadership:'kpiPersonalLeadershipBody',
  vendors:'kpiVendorsBody',
  matrixProducts:'kpiProductsBody',
  services:'kpiServicesBody',
  practices:'kpiPracticesBody',
  customers:'kpiCustomersBody',
  partners:'kpiPartnersBody'
};

const kpiFields={
  personalLeadership:['name','percentMultiplier','practiceMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  vendors:['name','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  matrixProducts:['department','group','practice','vendor','name','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  services:['department','group','practice','vendor','name','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  practices:['department','group','practice','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  customers:['name','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan'],
  partners:['name','practiceMultiplier','percentMultiplier','kpiTarget','kpiActual','bonusTarget','bonusActual','plan']
};

function createEmptyKpiData(){
  return {
    personalLeadership:[],
    vendors:[],
    matrixProducts:[],
    services:[],
    practices:[],
    customers:[],
    partners:[]
  };
}

let kpiDataDb=createEmptyKpiData();
let kpiCurrentPeriod='2026 · Q1';

function getKpiData(){
  return kpiDataDb;
}

function saveKpiData(data){
  kpiDataDb=data;
}

function kpiRowFromDatabase(row){
  return {
    id:Number(row.id),
    department:row.department||'',
    group:row.group_name||'',
    practice:row.practice||'',
    vendor:row.vendor||'',
    name:row.name||'',
    practiceMultiplier:row.practice_multiplier||'',
    percentMultiplier:row.percent_multiplier||'',
    kpiTarget:row.kpi_target||'',
    kpiActual:row.kpi_actual||'',
    bonusTarget:row.bonus_target||'',
    bonusActual:row.bonus_actual||'',
    plan:row.plan||''
  };
}

function kpiPayload(section,row,index){
  const employee=getEmployee();

  return {
    id:Number(row?.id||0),
    employee_id:Number(employee?.id||0),
    kpi_period:kpiCurrentPeriod,
    section_type:section,
    department:row?.department||'',
    group_name:row?.group||'',
    practice:row?.practice||'',
    vendor:row?.vendor||'',
    name:row?.name||'',
    practice_multiplier:row?.practiceMultiplier||'',
    percent_multiplier:row?.percentMultiplier||'',
    kpi_target:row?.kpiTarget||'',
    kpi_actual:row?.kpiActual||'',
    bonus_target:row?.bonusTarget||'',
    bonus_actual:row?.bonusActual||'',
    plan:row?.plan||'',
    sort_order:index
  };
}

async function loadKpiData(period=null){
  const employee=getEmployee();

  if(!employee||!employee.id){
    kpiDataDb=createEmptyKpiData();
    renderKpiTables();
    return false;
  }

  const periodSelect=document.getElementById('kpiPeriod');
  kpiCurrentPeriod=period||periodSelect?.value||kpiCurrentPeriod||'2026 · Q1';

  kpiDataDb=createEmptyKpiData();
  ensureSelectValue('kpiPeriod',kpiCurrentPeriod);
  renderKpiTables();

  try{
    const response=await fetch(
      `api/kpi/list.php?employee_id=${encodeURIComponent(employee.id)}&period=${encodeURIComponent(kpiCurrentPeriod)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load KPI records.');
    }

    (result.data||[]).forEach(row=>{
      const section=row.section_type;

      if(!Object.prototype.hasOwnProperty.call(kpiDataDb,section)){
        return;
      }

      kpiDataDb[section].push(
        kpiRowFromDatabase(row)
      );
    });

    renderKpiTables();
    return true;

  }catch(error){
    console.error('KPI load error:',error);
    showToast('Could not load KPI records.');
    return false;
  }
}

function kpiCell(section,index,field,value){
  if(field==='percentMultiplier'){
    return `<select onchange="saveKpiCell('${section}',${index},'${field}',this.value)">${['0','25','50','75','100','125','150'].map(x=>`<option ${String(value)===x?'selected':''}>${x}</option>`).join('')}</select>`;
  }

  return `<input value="${escapeHtml(value||'')}" onchange="saveKpiCell('${section}',${index},'${field}',this.value)">`;
}

function renderKpiTables(){
  const data=getKpiData();

  Object.entries(kpiBodies).forEach(([section,id])=>{
    const body=document.getElementById(id);
    if(!body)return;

    const rows=data[section]||[];
    const fields=kpiFields[section];

    body.innerHTML=rows.length
      ? rows.map((r,i)=>`<tr>${section==='personalLeadership'?'':`<td>${i+1}</td>`}${fields.map(f=>`<td>${kpiCell(section,i,f,r[f])}</td>`).join('')}<td><button class="icon-action danger" onclick="deleteKpiRow('${section}',${i})">×</button></td></tr>`).join('')
      : `<tr class="empty-row"><td colspan="${fields.length+(section==='personalLeadership'?1:2)}">No KPI rows configured.</td></tr>`;
  });

  ensureSelectValue('kpiPeriod',kpiCurrentPeriod);
}

async function saveKpiCell(section,index,field,value){
  const row=kpiDataDb[section]?.[index];

  if(!row){
    return;
  }

  row[field]=value;

  try{
    const response=await fetch(
      'api/kpi/save.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify(
          kpiPayload(section,row,index)
        )
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save KPI record.');
      return;
    }

    if(!row.id&&result.id){
      row.id=Number(result.id);
    }

  }catch(error){
    console.error('KPI save error:',error);
    showToast('Server error while saving KPI record.');
  }
}

async function addKpiRow(section){
  const employee=getEmployee();
  const fields=kpiFields[section];

  if(!employee||!employee.id||!fields){
    showToast('Employee or KPI section not found.');
    return;
  }

  const row={};

  fields.forEach(field=>{
    row[field]=field==='percentMultiplier'?'100':'';
  });

  const index=(kpiDataDb[section]||[]).length;

  try{
    const response=await fetch(
      'api/kpi/save.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify(
          kpiPayload(section,row,index)
        )
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not add KPI row.');
      return;
    }

    row.id=Number(result.id);
    kpiDataDb[section].push(row);
    renderKpiTables();
    showToast('KPI row added.');

  }catch(error){
    console.error('KPI add error:',error);
    showToast('Server error while adding KPI row.');
  }
}

async function deleteKpiRow(section,index){
  const row=kpiDataDb[section]?.[index];

  if(!row){
    return;
  }

  if(!row.id){
    kpiDataDb[section].splice(index,1);
    renderKpiTables();
    return;
  }

  try{
    const response=await fetch(
      'api/kpi/delete.php',
      {
        method:'POST',
        headers:{
          'Content-Type':'application/json'
        },
        body:JSON.stringify({
          id:row.id
        })
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not delete KPI row.');
      return;
    }

    kpiDataDb[section].splice(index,1);
    renderKpiTables();
    showToast('KPI row removed.');

  }catch(error){
    console.error('KPI delete error:',error);
    showToast('Server error while deleting KPI row.');
  }
}

async function saveKpiPeriod(value){
  kpiCurrentPeriod=value||'2026 · Q1';

  const loaded=await loadKpiData(kpiCurrentPeriod);

  if(loaded){
    showToast(`KPI period changed to ${kpiCurrentPeriod}.`);
  }
}

/* ---------- Loaded cost ---------- */
function calculateLoadedCost(){
  const num=id=>parseFloat(document.getElementById(id)?.value)||0;
  const rate=num('loadedBase')+num('loadedIndividual')+num('loadedPractice');
  setFieldValue('loadedRate',rate.toFixed(2));
  return rate;
}

async function loadLoadedCost(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    setFieldValue('loadedBase','0.00');
    setFieldValue('loadedIndividual','0.00');
    setFieldValue('loadedPractice','0.00');
    setFieldValue('loadedLastYear','0.00');
    setFieldValue('loadedRate','0.00');
    return false;
  }

  try{
    const response=await fetch(
      `api/loaded-cost/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load loaded cost.');
    }

    const d=result.data;

    if(!d){
      setFieldValue('loadedBase','0.00');
      setFieldValue('loadedIndividual','0.00');
      setFieldValue('loadedPractice','0.00');
      setFieldValue('loadedLastYear','0.00');
      setFieldValue('loadedRate','0.00');
      return true;
    }

    setFieldValue('loadedBase',d.base_cost??'0.00');
    setFieldValue('loadedIndividual',d.individual_cost??'0.00');
    setFieldValue('loadedPractice',d.practice_cost??'0.00');
    setFieldValue('loadedLastYear',d.last_year_cost??'0.00');

    const backendRate=parseFloat(d.loaded_rate);
    if(Number.isFinite(backendRate)){
      setFieldValue('loadedRate',backendRate.toFixed(2));
    }else{
      calculateLoadedCost();
    }

    return true;

  }catch(error){
    console.error('Loaded cost load error:',error);
    showToast('Could not load loaded cost.');
    return false;
  }
}

async function saveLoadedCost(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const num=id=>parseFloat(document.getElementById(id)?.value)||0;

  const payload={
    employee_id:employee.id,
    base_cost:num('loadedBase'),
    individual_cost:num('loadedIndividual'),
    practice_cost:num('loadedPractice'),
    last_year_cost:num('loadedLastYear')
  };

  try{
    const response=await fetch(
      'api/loaded-cost/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save loaded cost.');
      return false;
    }

    const rate=Number(result.loaded_rate);
    if(Number.isFinite(rate)){
      setFieldValue('loadedRate',rate.toFixed(2));
    }else{
      calculateLoadedCost();
    }

    showToast('Loaded cost saved successfully.');
    return true;

  }catch(error){
    console.error('Loaded cost save error:',error);
    showToast('Server error while saving loaded cost.');
    return false;
  }
}

/* ---------- Workflow email handoff ---------- */
function sendWorkflowEmail(subject){const e=getEmployee();const body=`Hello ${e.name},\n\nPlease review your ${subject} in SPS-BMS.\n\nRegards,\nHuman Resources`;window.location.href=`mailto:${e.email}?subject=${encodeURIComponent(`SPS-BMS — ${subject}`)}&body=${encodeURIComponent(body)}`;}
async function saveHRTalk(){
  const employee=getEmployee();

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  const answer=document.getElementById('hrTalkAnswer')?.value||'';
  const sendEmail=!!document.getElementById('hrTalkSendEmail')?.checked;

  const payload={
    employee_id:employee.id,
    answer:answer,
    send_email:sendEmail
  };

  try{
    const response=await fetch(
      'api/hr-talk/save.php',
      {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(payload)
      }
    );

    const result=await response.json();

    if(!result.success){
      showToast(result.message||'Could not save HR Talk.');
      return false;
    }

    closeModal('modalHRTalk');
    showToast('HR Talk saved successfully.');

    if(sendEmail){
      const body=`HR Talk follow-up for ${employee.name}\n\n${answer}`;
      window.location.href=`mailto:${employee.email}?subject=${encodeURIComponent('SPS-BMS — HR Talk')}&body=${encodeURIComponent(body)}`;
    }

    return true;

  }catch(error){
    console.error('HR Talk save error:',error);
    showToast('Server error while saving HR Talk.');
    return false;
  }
}

/* ---------- Performance dimensions ---------- */
async function selectDimension(button,name){
  if(!button)return false;

  const year=Number(
    document.getElementById('performanceYear')?.value||
    2026
  );

  if(
    !performanceState ||
    Number(performanceState.year)!==year
  ){
    await loadPerformanceData(year);
  }

  button
    .parentElement
    ?.querySelectorAll('button')
    .forEach(
      item=>item.classList.remove('selected')
    );

  button.classList.add('selected');

  performanceState.performance_dimension=
    name||'';

  const saved=
    await savePerformanceData({silent:true});

  if(saved){
    showToast(`${name} dimension selected.`);
  }

  return saved;
}

/* ---------- Plan persistence ---------- */
async function loadPlan(){
  const employee=getEmployee();

  setFieldValue('planGoal','');
  setFieldValue('planDate','');
  setFieldValue('planProgress','');
  setFieldValue('planNotes','');

  if(!employee||!employee.id){
    showToast('Employee ID not found.');
    return false;
  }

  try{
    const response=await fetch(
      `api/plans/get.php?employee_id=${encodeURIComponent(employee.id)}`,
      {cache:'no-store'}
    );

    const result=await response.json();

    if(!result.success){
      throw new Error(result.message||'Could not load development plan.');
    }

    const data=result.data;

    if(!data){
      return true;
    }

    setFieldValue('planGoal',data.goal||'');
    setFieldValue('planDate',data.target_date||'');
    setFieldValue('planProgress',data.progress||'');
    setFieldValue('planNotes',data.notes||'');

    return true;

  }catch(error){
    console.error('Development plan load error:',error);
    showToast('Could not load development plan.');
    return false;
  }
}

/* ---------- MySQL employee loading ---------- */
async function loadEmployeesFromDatabase(){
  try{
    const response=await fetch('api/employees/list.php',{cache:'no-store'});
    if(!response.ok) throw new Error(`HTTP ${response.status}`);

    const result=await response.json();
    if(!result.success) throw new Error(result.message||'Unable to load employees.');

    employees=(result.data||[]).map(employee=>({
      id:employee.id,
      name:employee.name||'',
      type:employee.employee_type||'Employee',
      job:employee.work_status||'',
      mgr:employee.supervisor_name||'',
      dept:employee.department||'',
      group:employee.employee_group||'',
      practice:employee.practice||'—',
      loc:employee.location||'',
      mobile:employee.mobile_no||'',
      email:employee.email||'',
      status:employee.status||'Active',
      databaseData:employee
    }));

    if(!employees.length){
      renderEmployees([]);
      updateEmployeeStats([]);
      showToast('No employees found in the database.');
      return;
    }

    if(!employees.some(employee=>employee.name===selectedEmployeeName)){
      selectedEmployeeName=employees[0].name;
    }

    populateEmployeeFilterOptions();
    filterEmployees();
    syncEmployeeContext();
    renderCertifications();
    updateBlogWordCount();

    if(document.getElementById('page-employee-detail')?.classList.contains('active')){
      renderEmployeeDetailAdvanced();
    }

    console.log('Employees loaded from MySQL:',employees);
  }catch(error){
    console.error('Employee database error:',error);
    renderEmployees([]);
    updateEmployeeStats([]);
    showToast('Could not load employees from database.');
  }
}

document.addEventListener('DOMContentLoaded',async()=>{
  await loadEmployeesFromDatabase();
});
