<script>

	import ToothChart from './components/ToothChart.svelte';
	import SideMenu from './components/SideMenu.svelte';
	import Xrays from './components/Xrays.svelte';
  	import Summary from './components/Summary.svelte';

	import {selectedTreatment, 
			selectedTooth,
			toothStates,
			treatmentHistories,
			treatments,
			dateInterval,
			dateIntervals,
			points,
			paintHistory} from './components/stores/store.js';

	import {checkin, patient} from './components/stores/store.js';
	
	import {getToothCodes, 
			fetchTreatments,
			fetchUserTreatments,
			fetchPaintings} from './api/doctor-treatment-api.js';

	import Tab, {Icon, Label} from '@smui/tab';
  	import TabBar from '@smui/tab-bar';

  	import {fade} from 'svelte/transition';

  	import moment from 'moment';


	$checkin = JSON.parse(document.getElementById('checkin').value);
	$patient = $checkin.user;

	  let iconTabs = [
		    {
		      icon: '',
		      label: 'Chart'
		    },
		    {
		      icon: '',
		      label: 'x-rays'
		    },	
		    {
		      icon: '',
		      label: 'Тэмдэглэл'
		    },
	];

	let toothCodes = getToothCodes();
    // initial states
    for (let i=0; i<toothCodes.length; i++){
        let state = {
            code: toothCodes[i],
            active: true,
            treatments: [],
            value: 0,
            decayLevel: 0,
            toothTypeId: 0
        }
        $toothStates[toothCodes[i]] = state;
    }

	let activeTab = iconTabs[0];

	fetchTreatments().then(response => {

			$treatments = response.data;
	});

	fetchPaintings({user_id: $patient.id}).then(response => {
		let history = response.data;
		for (let i=0; i<history.length; i++){
			let h = history[i];
			let p1 = JSON.parse(h.content);
			// console.log('parsed once');
			// console.log(p1);
			let p2 = JSON.parse(p1);
			// console.log('parsed twice');
			// console.log(p2);
			h.content = p2;
		}
		$paintHistory = history;

	}).catch(err=>{
		console.log(err);
		$points = [];
	})

	fetchUserTreatments($patient.id)
		.then(response => {
			let userTreatments = response.data;
			// console.log('fetched usertreatments');
			// console.log(userTreatments);
			userTreatments = userTreatments.map(u => {
				u.created_at = new moment(u.created_at).format('YYYY-MM-DD HH:mm:ss');
				return u;
			});

			$treatmentHistories = $treatmentHistories.concat(userTreatments);
			// update toothstates
			for (let i=0; i<userTreatments.length; i++){
				
				$dateIntervals.unshift(userTreatments[i].created_at);
				// escape treatmet for all tooths
				if (userTreatments[i].tooth_id == 0){
					continue;
				}
				let code = userTreatments[i].tooth_id;
				let treatments = [...$toothStates[code].treatments, userTreatments[i]];
				$toothStates[code].value = userTreatments[i].value;
				$toothStates[code].treatments = treatments;
			}
			$dateIntervals = $dateIntervals;
			console.log('date intervals:');
			console.log($dateIntervals);

			$toothStates = $toothStates;
		})
		.catch(err => {
			alert('Хадгалсан эмчилгээг татахад алдаа гарлаа');
			console.log(err);
		})
	// window.onbeforeunload = function(event)
 //    {
 //        return confirm("Confirm refresh");
 //    };
</script>

<div class="card mb-1">
	<div class="card-body">
		<TabBar bind:active={activeTab} tabs={iconTabs} let:tab>
		  <Tab {tab}>
		    <Icon class="material-icons">{tab.icon}</Icon>
		    <Label>{tab.label}</Label>
		  </Tab>
		</TabBar>
	</div>
</div>

	<div class="row" transition:fade
	     class:hidden={activeTab != iconTabs[0]}>
	    <ToothChart />
	    <SideMenu />
	</div>

	<div class="row" transition:fade
		class:hidden={activeTab != iconTabs[1]}>
		<Xrays />
	</div>

	{#if activeTab == iconTabs[2]}
		<div class="row" transition:fade>
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<Summary />
					</div>
				</div>
			</div>
		</div>
	{/if}
<style>

   .hidden{
   	display: none;
   }
</style>