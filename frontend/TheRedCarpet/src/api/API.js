export const getRegister = async (username, password) => {
  try {
    const apiHost = import.meta.env.VITE_API_HOST || "http://localhost:8888";
    const response = await fetch(
      `${apiHost}/TheRedCarpet/backend/API/register.php`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: username,
          password: password,
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