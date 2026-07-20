document.addEventListener('DOMContentLoaded',function(){var project=document.querySelector('[data-mjl-project]');var budget=document.querySelector('[data-mjl-budget]');if(!project||!budget)return;var options={
'Kitchen renovation':['Under $40,000','$40,000–$70,000','$70,000–$100,000','$100,000+'],
'Bathroom renovation':['Under $20,000','$20,000–$35,000','$35,000–$50,000','$50,000+'],
'Basement renovation':['Under $50,000','$50,000–$85,000','$85,000–$125,000','$125,000+'],
'Whole-home or full-gut renovation':['Under $150,000','$150,000–$300,000','$300,000–$500,000','$500,000+'],
'Custom home':['Under $1,000,000','$1,000,000–$1,500,000','$1,500,000–$2,500,000','$2,500,000+'],
'Other':['Under $25,000','$25,000–$50,000','$50,000–$100,000','$100,000+']};
function update(){var values=options[project.value]||[];budget.innerHTML='<option value="">Select a range</option>';values.forEach(function(v){var o=document.createElement('option');o.textContent=v;o.value=v;budget.appendChild(o);});}project.addEventListener('change',update);update();});