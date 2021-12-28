import { authUser, removeAuthUser } from "../../../services/firebase-auth";

export default {
  // update({ commit }, payload) {
  //   commit('SET', payload)
  // },

  // updates({ commit }, payload) {
  //   if (Array.isArray(payload)) {
  //     payload.map(e => commit('SET', e))
  //   }
  // },

  async signIn({ getters }, { context }) {

    const { user: userAuth } = await authUser();

    const { displayName: name, email } = userAuth;

    const { id } = await getters.getUserByEmail({ email });

    await context.$store.dispatch('updates', [
      {
        module: 'auth',
        key: "logged",
        value: true,
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "id",
        value: id,
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "name",
        value: name,
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "email",
        value: email,
      }
    ]);

    !!context && (await context.$router.push({ name: "Task" }));
  },

  async signOut(_, { context }) {

    await removeAuthUser()

    await context.$store.dispatch('updates', [
      {
        module: 'auth',
        key: "logged",
        value: false,
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "id",
        value: null,
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "name",
        value: '',
      },
      {
        module: 'auth',
        obj: "usuario",
        key: "email",
        value: '',
      },
      {
        module: 'task',
        key: "id",
        value: null,
      },
      {
        module: 'task',
        key: "filter",
        value: '',
      },
      {
        module: 'task',
        key: "taskList",
        value: [],
      }
    ]);

    !!context && (await context.$router.push({ name: "Home" }));
  },
}