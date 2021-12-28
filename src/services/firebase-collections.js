import { app, db } from './firebase'
import { query, where, collection, getDocs, addDoc, doc, updateDoc } from 'firebase/firestore';

// USUARIO
export const getUserByEmail = async email => {
  const Ref = collection(db, `tasks-usuario`);

  const q = query(Ref, where("email", "==", `${email}`));

  const querySnapshot = await getDocs(q);

  const doc = querySnapshot.docs[0] || null

  if (doc) {
    const id = doc.id
    const res = doc.data()

    return { id, ...res }
  }

  return null
}

export const createUserByEmail = async email => {
  const Ref = collection(db, `tasks-usuario`);

  const data = { email }

  return await addDoc(Ref, data);
}

// TAREFAS
export const getTaskByUserId = async (id) => {
  const Ref = collection(db, 'tasks-list');

  const q = query(Ref, where("userId", "==", `${id}`));

  const querySnapshot = await getDocs(q);

  const doc = querySnapshot.docs[0] || null

  if (!!doc) {
    const id = doc.id
    const res = doc.data()

    return { id, ...res }
  }
  return null
}

export const createTaskByUserId = async userId => {
  const Ref = collection(db, `tasks-list`);

  const data = {
    filter: 'enable',
    userId,
    tasks: []
  }

  return await addDoc(Ref, data);
}

export const updateTaskById = async (taskId, payload) => {
  const Ref = doc(db, "tasks-list", taskId);

  await updateDoc(Ref, payload);
}
