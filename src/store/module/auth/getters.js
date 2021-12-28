import {
  getUserByEmail,
  createUserByEmail,
} from "../../../services/firebase-collections";

export default {
  isLogged (state){
    return state.logged
  },

  getUser(state) {
    return state?.usuario || {}
  },
  
  getUserId(state) {
    return state?.usuario?.id || null
  },

  getUserByEmail: (_, getters) => async ({ email }) => {
    let result = await getUserByEmail(email);

    if (!result) {
      await createUserByEmail(email);
      await getters.getUserByEmail({ email });
      return;
    }

    return {
      id: result.id,
    };
  },

}