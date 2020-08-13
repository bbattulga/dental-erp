<script>

	import ToothChart from './components/ToothChart.svelte';
	import SideMenu from './components/SideMenu.svelte';
	import {selectedTreatment, selectedTooth,
			toothStates} from './components/stores/store.js';
	import {checkin, patient} from './components/stores/store.js';
	
	import {getToothCodes} from './api/doctor-treatment-api.js';


	import Tab, {Icon, Label} from '@smui/tab';
  	import TabBar from '@smui/tab-bar';

  	import Xrays from './components/Xrays.svelte';
  	import Summary from './components/Summary.svelte';



	$checkin = document.getElementById('checkin');
	$patient = checkin.user;

	  let iconTabs = [
		    {
		      icon: '',
		      label: 'Chart'
		    },
		    {
		      icon: '',
		      label: 'Тэмдэглэл'
		    },
		    {
		      icon: '',
		      label: 'x-rays'
		    }
	];

	let toothCodes = getToothCodes();
    // initial states
    for (let i=0; i<toothCodes.length; i++){
        let state = {
            code: toothCodes[i],
            active: true,
            treatments: [null],
            value: 0,
            decayLevel: 0,
            toothTypeId: 0
        }
        $toothStates[toothCodes[i]] = state;
    }
    $toothStates = $toothStates;

	let activeTab = iconTabs[0];

	// window.onbeforeunload = function(event)
 //    {
 //        return confirm("Confirm refresh");
 //    };
</script>

<TabBar bind:active={activeTab} tabs={iconTabs} let:tab>
  <Tab {tab}>
    <Icon class="material-icons">{tab.icon}</Icon>
    <Label>{tab.label}</Label>
  </Tab>
</TabBar>

{#if activeTab == iconTabs[0]}
	<div class="row">
	    <ToothChart />
	    <SideMenu />
	</div>

{:else if activeTab == iconTabs[1]}
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<Summary />
				</div>
			</div>
		</div>
	</div>
{:else if activeTab == iconTabs[2]}
	<div class="row">
		<Xrays />
	</div>
{/if}

<style>

</style>