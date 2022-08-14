import { useRouter } from "vue-router";

export const useRouterHook = () => {
	const router = useRouter();


	function toPage(path: string) {
		router.push({
			path,
		});
	}

	return {
		toPage
	}
}
