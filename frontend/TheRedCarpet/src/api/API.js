export const getRegister = async (username, password, email, birthdate, first_name, last_name) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888/TheRedCarpet/Backend/";
    const response = await fetch(
      `${apiHost}/API/user/register.php`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: username,
          password: password,
          email: email,
          birthdate: birthdate,
          first_name: first_name,
          last_name: last_name,
        }),
      }
    );

    const data = await response.json();

    if (response.ok) {
      return { message: data.message, error: false };
    } else {
      return { message: data.message || "An error occurred.", error: true };
    }
  } catch (err) {
    return {
      message: "Failed to connect to the server. " + err.message,
      error: true,
    };
  }
};
