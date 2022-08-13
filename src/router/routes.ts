import HomeView from '../views/HomeView.vue'

export default [
	{
		path: '/',
		name: 'home',
		component: HomeView
	},
	{
		path: '/place-order',
		name: 'placeOrder',
		component: () => import('../views/PlaceOrder.vue')
	},
	{
		path: '/track-order',
		name: 'trackOrder',
		component: () => import('../views/TrackOrder.vue')
	}
]