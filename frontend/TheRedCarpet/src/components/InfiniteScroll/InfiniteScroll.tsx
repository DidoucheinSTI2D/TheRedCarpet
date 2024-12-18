import React from "react";
import { useEffect, useState } from "react";
import { useInView } from "react-intersection-observer";
import Post from "../Post/Post";
import { getOngoingRepresentations } from "../../api/API";

interface Representation {
  first_date: string;
  last_date: string;
  room_id: number;
  spectacle_id: number;
  spectacle_synopsis: string;
  spectacle_title: string;
}

function InfiniteScroll() {
  const [representations, setRepresentations] = useState<Representation[]>([]);
  const [visibleRepresentations, setVisibleRepresentations] = useState<
    Representation[]
  >([]);
  const [position, setPosition] = useState(5);
  const [isLoading, setIsLoading] = useState(true);
  const { ref, inView } = useInView({
    threshold: 0.5,
  });

  const spectacles = [
    {
      "spectacle_id": 1,
      "spectacle_title": "Le Roi Lion",
      "spectacle_synopsis": "Une adaptation musicale du film classique de Disney, racontant l'histoire de Simba, un jeune lion qui doit retrouver son chemin après la perte de son père."
    },
    {
      "spectacle_id": 2,
      "spectacle_title": "Les Misérables",
      "spectacle_synopsis": "Une épopée musicale basée sur le roman de Victor Hugo, suivant la vie de Jean Valjean et les luttes pour la justice et la rédemption dans la France du XIXe siècle."
    },
    {
      "spectacle_id": 3,
      "spectacle_title": "Carmen",
      "spectacle_synopsis": "Un opéra passionné de Georges Bizet, qui raconte l'histoire tragique d'amour entre Don José et la belle gitane Carmen."
    },
    {
      "spectacle_id": 4,
      "spectacle_title": "Notre-Dame de Paris",
      "spectacle_synopsis": "Une comédie musicale inspirée du roman de Victor Hugo, mettant en scène l'amour impossible entre Quasimodo, le bossu de Notre-Dame, et la belle Esmeralda."
    },
    {
      "spectacle_id": 5,
      "spectacle_title": "Hamilton",
      "spectacle_synopsis": "Une comédie musicale révolutionnaire qui retrace la vie d'Alexander Hamilton, l'un des pères fondateurs des États-Unis, à travers le hip-hop et le R&B."
    },
    {
      "spectacle_id": 6,
      "spectacle_title": "Mamma Mia!",
      "spectacle_synopsis": "Une comédie musicale joyeuse basée sur les chansons du groupe ABBA, racontant l'histoire d'une jeune femme qui cherche à découvrir l'identité de son père avant son mariage."
    },
    {
      "spectacle_id": 7,
      "spectacle_title": "Phantom of the Opera",
      "spectacle_synopsis": "Un opéra musical de Andrew Lloyd Webber, qui suit l'histoire d'un mystérieux fantôme qui hante l'Opéra de Paris et son obsession pour la chanteuse Christine Daaé."
    },
    {
      "spectacle_id": 8,
      "spectacle_title": "West Side Story",
      "spectacle_synopsis": "Une adaptation moderne de Roméo et Juliette, se déroulant à New York, où deux gangs rivaux s'affrontent, tandis que deux jeunes amoureux tentent de surmonter les obstacles de leur environnement."
    },
    {
      "spectacle_id": 9,
      "spectacle_title": "Billy Elliot",
      "spectacle_synopsis": "Une comédie musicale émouvante sur un jeune garçon qui découvre sa passion pour la danse, défiant les attentes de sa famille et de sa communauté dans une ville minière du nord de l'Angleterre."
    },
    {
      "spectacle_id": 10,
      "spectacle_title": "Les producteurs",
      "spectacle_synopsis": "Une comédie musicale hilarante sur un producteur de Broadway qui tente de monter le pire spectacle jamais réalisé pour escroquer des investisseurs."
    },
  ];

  useEffect(() => {
    setRepresentations(spectacles);
    setVisibleRepresentations(spectacles.slice(0, 5));
    setIsLoading(false);
  }, []);

  useEffect(() => {
    if (inView && position < representations.length) {
      const nextBatch = representations.slice(position, position + 5);
      setVisibleRepresentations((prev) => [...prev, ...nextBatch]);
      setPosition((prev) => prev + 5);
    }
  }, [inView, position, representations]);

  if (isLoading) {
    return (
      <div className="flex justify-center items-center h-screen">
        <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-500"></div>
      </div>
    );
  }

  return (
    <div className="flex flex-col items-center justify-center p-4 gap-[4rem]">
      <div className="flex flex-col items-center justify-center h-[50vh] w-full gap-[1rem]">
        <p className=" text-3xl font-bold">Magic pick</p>
        <p className=" text-xl font-bold">Your Ultimate Guide to Theatre and Cinema Experiences!</p>
      </div>
      <div className="flex flex-col gap-[1.5rem]">
        {visibleRepresentations.map((representation, index) => (
          <Post
            key={`${representation.spectacle_id}-${index}`}
            data={{
              name: representation.spectacle_title,
              description: representation.spectacle_synopsis,
              likes: 0, // You might want to add this to your API response
            }}
            position={index}
          />
        ))}
      </div>
      {position < representations.length && (
        <div ref={ref} className="text-center mt-6">
          <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-500"></div>
        </div>
      )}
    </div>
  );
}

export default InfiniteScroll;
